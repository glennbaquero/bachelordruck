<?php

namespace Domain\Banners\Actions;

use Domain\Banners\Models\Banner;

class BannerDeleteAction
{
    public function __invoke(Banner $banner): void
    {
        $banner->delete();
    }
}
