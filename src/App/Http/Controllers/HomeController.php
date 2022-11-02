<?php

namespace App\Http\Controllers;

use Domain\Pages\Models\Language;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    public function __invoke(string $languageCode = 'de'): Application|Factory|View|RedirectResponse
    {
        /** @var Language $language */
        $language = Language::query()
            ->where('languageCode', $languageCode)
            ->first();

        if (! $language) {
            return abort('404');
        }

        return redirect()->route('page.home', ['language' => $languageCode]);
    }
}
