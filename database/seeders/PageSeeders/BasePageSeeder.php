<?php

namespace Database\Seeders\PageSeeders;

use Domain\Pages\Actions\PageLanguageCreateAction;
use Domain\Pages\DataTransferObjects\PageData;
use Domain\Pages\DataTransferObjects\PageLanguageData;
use Domain\Pages\Models\Language;
use Domain\Pages\Models\Layout;
use Domain\Pages\Models\PageLanguage;
use Illuminate\Database\Eloquent\Model;

abstract class BasePageSeeder
{
    protected ?string $parentName = null;

    abstract public function definition(): array;

    public function seed(): void
    {
        $definition = $this->definition();

        $parent = PageLanguage::query()
            ->where('name', $definition['parent_name'])
            ->where('language_id', $definition['language_id'])
            ->first();

        $pageLanguage = PageLanguage::query()
            ->where('name', $definition['name'])
            ->where('language_id', $definition['language_id'])
            ->first();

        if ($pageLanguage) {
            return;
        }

        $pageLanguageData = new PageLanguageData(
            page_id: null,
            name: $definition['name'],
            title: $definition['title'] ?? $definition['name'],
            url: $definition['url'],
            language_id: $definition['language_id'],
            layout_id: $definition['layout_id'] ?? null,
            active: $definition['active'] ?? true,
            visible: $definition['visible'] ?? true,
        );

        app(PageLanguageCreateAction::class)($pageLanguageData, new PageData(parent_id: $parent?->id));
    }

    protected function language(string $languageCode = 'de'): Layout|Model
    {
        return Language::query()->where('languageCode', $languageCode)->first();
    }

    protected function layout(string $token): Layout|Model
    {
        return Layout::query()->where('token', $token)->first();
    }
}
