<?php

namespace App\Http\Controllers;

use Domain\Pages\Models\PageLanguage;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __invoke(string $url): View
    {
        $page = PageLanguage::where('url', "/{$url}")->where('language_id', 1)->first();

        if ($page) {
            return view('page', [
                'page' => $page,
            ]);
        }

        return view('404');
    }
}
