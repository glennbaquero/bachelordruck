<?php

namespace App\News\Controllers\Frontend;

use Domain\News\Models\News;
use Domain\Pages\Models\Language;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController
{
    public function index(string $language, Request $request)
    {
        $language = Language::where('languageCode', $language)->first();
        $news = News::query()->language($language->id)->paginate(1);

        return view('frontend.news', compact('news'));
    }

    public function slug(string $language, string $slug): View
    {
        $news = News::query()->whereSlug($slug)->first();

        return view('frontend.news-detail', compact('slug', 'news'));
    }
}
