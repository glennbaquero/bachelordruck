<?php

namespace Domain\Containers\Actions;

use Domain\Containers\Enums\ContainerStatusEnum;
use Domain\Containers\Models\Container;
use Domain\Pages\Models\PageLanguage;
use Illuminate\Support\Facades\DB;

class ContainerCopyAction
{
    public function __invoke(PageLanguage $pageLanguage, array $containerIds): void
    {
        $now = now()->format('Y-m-d H:i:s');

        $containersToCopy = Container::query()
            ->select([
                DB::raw($pageLanguage->id.' as pages_language_id'),
                'sort',
                'content',
                'image_alignment',
                'title',
                'type',
                'options',
                'url',
                DB::raw('id as  source_container_id'),
                DB::raw("'".ContainerStatusEnum::COPYING->value."' as status"),
            ])
            ->whereIn('id', $containerIds)
            ->get()
            ->toArray();

        $containersCount = Container::query()
            ->where('pages_language_id', $pageLanguage->id)
            ->count() + 1;

        foreach ($containersToCopy as &$container) {
            $container['sort'] = $containersCount++;
            $container['created_at'] = $now;
            $container['updated_at'] = $now;
        }

        Container::insert($containersToCopy);
    }
}
