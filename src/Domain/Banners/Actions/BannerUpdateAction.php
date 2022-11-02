<?php

namespace Domain\Banners\Actions;

use Domain\Banners\DataTransferObjects\BannerData;
use Domain\Banners\Models\Banner;

class BannerUpdateAction
{
    public function __invoke(Banner $banner, BannerData $bannerData): Banner
    {
        $banner->page_id = $bannerData->page_id;
        $banner->language_id = $bannerData->language_id;
        $banner->transmission = $bannerData->transmission;
        $banner->title = $bannerData->title;
        $banner->description = $bannerData->description;
        $banner->url = $bannerData->url;
        $banner->link_text = $bannerData->link_text;
        $banner->sort = $bannerData->sort;
        $banner->status = $bannerData->status;
        $banner->save();

        return $banner->refresh();
    }
}
