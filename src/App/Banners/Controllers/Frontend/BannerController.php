<?php

namespace App\Banners\Controllers\Frontend;

use Illuminate\View\View;

class BannerController
{
    public function banner(int $page): View
    {
        return view('frontend.banner', compact('page'));
    }
}
