<?php

namespace Domain\News\QueryBuilders;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Builder;

class NewsQueryBuilder extends Builder
{
    public function language(int $languageId): self
    {
        return $this->where('language_id', $languageId);
    }

    public function whereSlug(string $slug): self
    {
        return $this->where('slug', $slug);
    }

    public function active(): self
    {
        return $this->where('status', StatusEnum::ACTIVE->value);
    }
}
