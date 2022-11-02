<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            LanguageSeeder::class,
            LayoutSeeder::class,
            PageSeeder::class,
            GallerySeeder::class,
            PricePageContentSeeder::class,
            ProductSeeder::class,
            ProductBackCoverSeeder::class,
            ProductBookCornerColorSeeder::class,
            ProductRibbonColorSeeder::class,
            ProductFoilSeeder::class,
            ProductCoverImprintColorSeeder::class,
            AdditionalServiceSeeder::class,
            HomeContentSeeder::class,
            ContactSeeder::class,
        ]);
    }
}
