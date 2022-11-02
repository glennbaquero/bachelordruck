<?php

namespace Database\Seeders;

use Domain\Galleries\Models\Gallery;
use Domain\Pages\Models\Language;
use Domain\Pages\Models\PageLanguage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bilderPageLanguage = PageLanguage::query()->where('name', 'Bildergalerie')->first();
        $language = Language::query()->where('languageCode', 'de')->first();

        $galleries = [
            [
                'id' => 1,
                'language_id' => $language->id,
                'page_id' => $bilderPageLanguage->page->id,
                'title' => 'Bildergalerie',
                'status' => 'active',
                'sort' => 1,
                'slug' => 'bildergalerie',
            ],
            [
                'id' => 2,
                'language_id' => $language->id,
                'page_id' => $bilderPageLanguage->page->id,
                'title' => 'Logos',
                'status' => 'active',
                'sort' => 1,
                'slug' => 'logos',
            ],
        ];

        foreach ($galleries as $gallery) {
            Gallery::updateOrCreate(Arr::only($gallery, 'id'), $gallery);
        }

        /** @var Gallery $bilderGalerie */
        $bilderGalerie = Gallery::with('media')
            ->where('slug', 'bildergalerie')
            ->first();

        if ($bilderGalerie->media->count() === 0) {
            $images = File::allFiles(database_path('seeders/images/picture_gallery'));

            foreach ($images as $image) {
                $bilderGalerie->addMedia($image->getPathname())
                ->preservingOriginal()
                ->toMediaCollection('images');
            }
        }

        /** @var Gallery $bilderGalerie */
        $logos = Gallery::with('media')
            ->where('slug', 'logos')
            ->first();

        if ($logos->media->count() === 0) {
            $images = File::allFiles(database_path('seeders/images/logos'));

            foreach ($images as $image) {
                $logos->addMedia($image->getPathname())
                ->preservingOriginal()
                ->toMediaCollection('images');
            }
        }
    }
}
