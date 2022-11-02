<?php

namespace Database\Seeders;

use Domain\Containers\Models\Container;
use Domain\Galleries\Models\Gallery;
use Domain\Pages\Models\Language;
use Domain\Pages\Models\PageLanguage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kontaktPageLanguage = PageLanguage::query()->where('name', 'Kontakt')->first();
        $language = Language::query()->where('languageCode', 'de')->first();
        $images = File::allFiles(database_path('seeders/images/kontakt'));

        $content = [
            'sort' => 1,
            'title' => 'SBG Copyshop seit 2004 an der Uni Augsburg',
            'image_alignment' => 'left',
            'content' => '<p>SBG CopyShop an der UNI<br>Salomon-Idler Straße 24F<br>86159 Augsburg</p><p>Telefon: <a target="_self" rel="noopener noreferrer nofollow" class="blue-500" href="tel:0821581020">0821/581020</a></p><p><a target="_blank" rel="noopener noreferrer nofollow" class="blue-500" href="mailto:info@bachelor-druck.de">info@bachelor-druck.de</a></p><p><a target="_blank" rel="noopener noreferrer nofollow" class="blue-500" href="mailto:sbg-copyshop@t-online.de">sbg-copyshop@t-online.de</a></p><p>Öffnungszeiten von Montag bis Freitag von 9 Uhr bis 18 Uhr</p>',
            'type' => 'headline_text_image',
            'pages_language_id' => $kontaktPageLanguage->id,
            'status' => 'ready',
        ];

        $gallery = [
            'language_id' => $language->id,
            'page_id' => $kontaktPageLanguage->id,
            'title' => 'Kontaktgalerie',
            'status' => 'active',
            'sort' => 1,
            'slug' => 'kontaktgalerie',
        ];

        if (! Container::where('title', $content['title'])->exists()) {
            $container = Container::create($content);
        } else {
            $container = Container::where('title', $content['title'])->first();
        }

        if (! Gallery::where('slug', $gallery['slug'])->exists()) {
            Gallery::create($gallery);
        }

        $container->addMedia($images[0]->getPathname())
            ->withResponsiveImages()
            ->preservingOriginal()
            ->toMediaCollection('images');

        $kontaktGalerie = Gallery::with('media')
            ->where('slug', 'kontaktgalerie')
            ->first();

        if ($kontaktGalerie->media->count() === 0) {
            foreach ($images as $key => $image) {
                if ($key > 0) {
                    $kontaktGalerie->addMedia($image->getPathname())
                        ->withResponsiveImages()
                        ->preservingOriginal()
                        ->toMediaCollection('images');
                }
            }
        }
    }
}
