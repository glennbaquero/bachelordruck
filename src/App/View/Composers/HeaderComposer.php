<?php

namespace App\View\Composers;

use Domain\Pages\Helpers\NavigationHelper;
use Illuminate\View\View;
use Support\Helpers\FrontendLanguageHelper;

class HeaderComposer
{
    public function __construct(public NavigationHelper $navigationHelper, public FrontendLanguageHelper $frontendHelper)
    {
    }

    public function compose(View $view)
    {
        $view->with('language', $this->frontendHelper->get());
        $view->with('helper', $this->navigationHelper);
        $view->with('user', auth()->user());
    }
}
