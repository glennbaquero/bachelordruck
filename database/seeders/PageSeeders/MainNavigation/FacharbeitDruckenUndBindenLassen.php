<?php

namespace Database\Seeders\PageSeeders\MainNavigation;

use Database\Seeders\PageSeeders\BasePageSeeder;

class FacharbeitDruckenUndBindenLassen extends BasePageSeeder
{
    protected ?string $parentName = 'Main Navigation';

    public function definition(): array
    {
        return [
            'page_id' => null,
            'name' => 'Facharbeit drucken und binden lassen',
            'title' => 'Facharbeit drucken und binden lassen',
            'url' => '/facharbeit-drucken-und-binden-lassen',
            'language_id' => $this->language()->id,
            'layout_id' => $this->layout('bachelordruck.technical-work-printing-and-binding-let')->id,
            'active' => true,
            'visible' => false,
            'parent_name' => 'Main Navigation',
        ];
    }
}
