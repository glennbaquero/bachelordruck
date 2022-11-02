<?php

namespace App\Pages\Controllers\Frontend;

use App\Enums\StatusEnum;
use App\Pages\Services\ContactUsMailService;
use Domain\Pages\Collections\PageLanguageCollection;
use Domain\Pages\Helpers\NavigationHelper;
use Domain\Pages\Models\Language;
use Domain\Pages\Models\PageLanguage;
use Domain\Pages\Services\PageLanguageServices;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController
{
    public function index(string $language, string $url = null): View | RedirectResponse
    {
        $galleries = null;
        $news = null;
        $language = Language::query()->where('languageCode', $language)->first();

        /** @var PageLanguageCollection $pageLanguages */
        $pageLanguages = app(PageLanguageServices::class)->getPageLanguages($language);

        $pageLanguage = $pageLanguages
            ->where('url', '/'.$url ?? '')
            ->first();

        if ($pageLanguage) {
            $pageLanguage->loadMissing([
                'language',
                'layout',
                'page',
                'containers.media',
            ]);

            $layout = $pageLanguage->layout?->token ?? config('cms.page_layout');

            return view('layouts.'.$layout, [
                'page' => $pageLanguage,
                'showBanner' => (bool) $pageLanguage->page->banner,
                'banner' => $pageLanguage->page->banner,
                'galleries' => $galleries,
                'news' => $news,
                'mainNavigation' => NavigationHelper::formatted('Main Navigation', $language),
                'footerNavigation' => NavigationHelper::formatted('Footer Navigation', $language),
            ]);
        }

        return view('404');
    }

    public function any(Request $request, string $language, string $any)
    {
        $banner = null;
        $queries = explode('/', $any);
        [$page, $child] = $queries;
        $organs = null;

        $language = Language::where('languageCode', $language)->first();
        $pageLanguage = PageLanguage::where('language_id', $language->id)->where('url', "/{$page}")->first();
        $childLanguage = PageLanguage::where('language_id', $language->id)->where('url', "/{$any}")->first();
        $childBanner = $childLanguage->page->banner ?? null;
        $parentBanner = $pageLanguage->page->banner ?? null;

        if ($parentBanner && $parentBanner->transmission && $parentBanner->status === StatusEnum::ACTIVE->value) {
            $banner = $parentBanner;
        }

        if ($childBanner && $childBanner->status === StatusEnum::ACTIVE->value) {
            $banner = $childBanner;
        }

        if (! $language || ! $pageLanguage || ! $childLanguage) {
            return view('404');
        }

        if ($childLanguage->name === 'Neubauten' || $childLanguage->name === 'New buildings') {
            $this->assignLayout($request);
            $this->assignFilter($request);

            $organs = Organ::query()->loadData($request, $language, false);
        }

        if ($childLanguage->name === 'Restaurierungen' || $childLanguage->name === 'Restorations') {
            $this->layout = 'plain';
            $this->assignFilter($request);
            $organs = Organ::query()->loadData($request, $language, true);
        }

        if (session()->get('organs.location')) {
            $organs = $organs->get();
        } else {
            $totalOrgans = $organs?->count();
            $organs = $organs->get();
        }

        if ($organs) {
            $organs->loadMissing('media');
        }

        return view('frontend.page', [
            'page' => $childLanguage,
            'banner' => $banner,
            'showBanner' => (bool) $banner,
            'organs' => $organs ?? null,
            'layout' => $this->layout ?? null,
        ]);
    }

    public function getContact(string $language)
    {
        return view('frontend.contact-us');
    }

    public function postPage(Request $request, ContactUsMailService $contactUsMailService)
    {
        $language = Language::where('languageCode', $request->language)->first();
        $pageLanguage = PageLanguage::where('language_id', $language->id)->where('url', "/{$request->page}")->first();

        if ($pageLanguage->name === 'Contact' || $pageLanguage->name === 'Kontakt') {
            $request->validate([
                'gender' => 'required',
                'first-name' => 'required',
                'last-name' => 'required',
                'email' => 'required|email',
                recaptchaFieldName() => recaptchaRuleName(),
            ]);
            $contactUsMailService->handle($request);

            return back()->with('message', 'Successfully sent.');
        }

        return back();
    }
}
