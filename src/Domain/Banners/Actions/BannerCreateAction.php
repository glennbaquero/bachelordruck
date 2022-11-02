<?php

namespace Domain\Banners\Actions;

use Domain\Banners\DataTransferObjects\BannerData;
use Domain\Banners\Models\Banner;

class BannerCreateAction
{
    public function __invoke(BannerData $bannerData): Banner
    {
        return Banner::create([
            'page_id' => $bannerData->page_id,
            'language_id' => $bannerData->language_id,
            'transmission' => $bannerData->transmission,
            'title' => $bannerData->title,
            'description' => $bannerData->description,
            'url' => $bannerData->url,
            'link_text' => $bannerData->link_text,
            'sort' => $bannerData->sort,
            'status' => $bannerData->status,
        ]);
    }
}
