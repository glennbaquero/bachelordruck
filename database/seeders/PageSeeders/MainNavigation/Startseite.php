<?php

namespace Database\Seeders\PageSeeders\MainNavigation;

use Database\Seeders\PageSeeders\BasePageSeeder;

class Startseite extends BasePageSeeder
{
    protected ?string $parentName = 'Main Navigation';

    public function definition(): array
    {
        return [
            'page_id' => null,
            'name' => 'Startseite',
            'title' => 'Startseite',
            'url' => '/',
            'language_id' => $this->language()->id,
            'layout_id' => $this->layout('bachelordruck.home')->id,
            'active' => true,
            'visible' => true,
            'parent_name' => 'Main Navigation',
        ];
    }
}
