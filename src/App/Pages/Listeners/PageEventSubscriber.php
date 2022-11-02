<?php

namespace App\Pages\Listeners;

use App\Pages\Events\PageCreated;
use App\Pages\Events\PageDeleted;
use App\Pages\Events\PageUpdated;

class PageEventSubscriber
{
    public function clearNavigationCache()
    {
        cache()->forget('page-navigation');
    }

    public function subscribe($events)
    {
        return [
            PageCreated::class => 'clearNavigationCache',
            PageUpdated::class => 'clearNavigationCache',
            PageDeleted::class => 'clearNavigationCache',
        ];
    }
}
