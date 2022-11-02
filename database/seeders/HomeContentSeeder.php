<?php

namespace Database\Seeders;

use Domain\Banners\Models\Banner;
use Domain\Containers\Models\Container;
use Domain\Pages\Models\Language;
use Domain\Pages\Models\PageLanguage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class HomeContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Banner::count() > 0) {
            return;
        }

        $page = PageLanguage::query()->where('name', 'Startseite')->first();
        $language = Language::query()->where('languageCode', 'de')->first();

        $images = File::allFiles(database_path('seeders/images/home'));

        $banner = Banner::create([
            'page_id' => $page->id,
            'language_id' => $language->id,
            'transmission' => 1,
            'title' => 'Banner image',
            'description' => '<p>Banner image</p>',
            'sort' => 1,
            'status' => 'active',
        ]);

        $container = Container::create([
            'sort' => 1,
            'title' => 'IHR COPYSHOP FUR PROFESSIONELLE DRUCK UND BINDUNGEN AN DER UNI AUGSBURG',
            'content' => '<p>Lorem ipsum dolor sit amet consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nasccetur ridiculus.</p><p>Done pede justo, fringilla vel, alique nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula porttitor eu, consequat vitae</p>',
            'type' => 'headline_text_image',
            'pages_language_id' => $page->id,
            'status' => 'ready',
            'image_alignment' => 'right',
        ]);

        $banner->addMedia($images[0]->getPathname())
        ->preservingOriginal()
        ->toMediaCollection('image');

        $container->addMedia($images[1]->getPathname())
            ->preservingOriginal()
            ->toMediaCollection('images');
    }
}
