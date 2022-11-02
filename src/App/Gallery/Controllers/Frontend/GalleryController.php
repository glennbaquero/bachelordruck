<?php

namespace App\Gallery\Controllers\Frontend;

use App\Gallery\Queries\GalleryIndexQuery;
use Domain\Galleries\Models\Gallery;
use Illuminate\View\View;

class GalleryController
{
    public function index(GalleryIndexQuery $query, string $language): View
    {
        $galleries = $query->paginate(50);

        return view('frontend.gallery', compact('galleries'));
    }

    public function gallery(string $language, Gallery $gallery)
    {
        return view('frontend.gallery-detail', compact('gallery'));
    }
}
