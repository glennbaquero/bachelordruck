<?php

use Domain\Pages\Models\PageLanguage;
use function Pest\Laravel\get;

it('display landing page correctly', function () {
    $pageLanguages = PageLanguage::get();

    $this->followingRedirects()
        ->get('/')
        ->assertSee([
            'FACHARBEIT',
            'DRUCKEN',
            'LASSEN',
            'BINDEN',
        ]);
});

it('display pages correctly', function () {
    $pageLanguages = PageLanguage::with(['page.children', 'language'])
        ->where('url', '!=', '')
        ->get();

    foreach ($pageLanguages as $pageLanguage) {
        $url = $pageLanguage->language->languageCode.$pageLanguage->url;

        if ($pageLanguage->url === '/') {
            get($url)->assertRedirect();
        } elseif ($pageLanguage->page->children->count() === 0) {
            get($url)->assertSuccessful();
        }
    }
})->skip();
