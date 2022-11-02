<?php

namespace Domain\Pages\Helpers;

use Domain\Pages\Models\Page;
use Domain\Pages\Models\PageLanguage;
use Illuminate\Database\Eloquent\Collection;

class PageTreeHelper
{
    private Collection $pages;

    private Collection $pagesLanguages;

    private array $select = [];

    public function getSelectTree(): array
    {
        //        $this->loadLanguages();
        $this->loadPages();
        $this->loadPagesLanguage();

        $this->buildArray();

        return $this->select;
    }

    private function loadPages(): void
    {
        $this->pages = Page::with('ancestors')->get();
    }

    private function loadPagesLanguage(): void
    {
        $this->pagesLanguages = PageLanguage::all();
    }

    private function buildArray(): void
    {
        foreach ($this->pages as $page) {
            $this->select[] = [
                'id' => $page->id,
                'label' => $this->buildPath($page),
            ];
        }
    }

    private function getNodeLabel(int $page_id)
    {
        return $this->pagesLanguages->firstWhere('page_id', $page_id)['name'] ?? 'x';
    }

    private function buildPath(Page $page): string
    {
        $parts = [];
        foreach ($page->getAncestors() as $ancestor) {
            $parts[] = $this->getNodeLabel($ancestor->id);
        }
        $parts[] = $this->getNodeLabel($page->id);

        return implode(' · ', $parts);
    }
}
