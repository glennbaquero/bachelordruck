<?php

namespace Database\Seeders;

use Database\Seeders\PageSeeders\FooterNavigation\AGB;
use Database\Seeders\PageSeeders\FooterNavigation\Datenschutzerklarung;
use Database\Seeders\PageSeeders\FooterNavigation\FooterNavigation;
use Database\Seeders\PageSeeders\FooterNavigation\Impressum;
use Database\Seeders\PageSeeders\FooterNavigation\Widerrufsbelehrung;
use Database\Seeders\PageSeeders\FooterNavigation\Zahlungsarten;
use Database\Seeders\PageSeeders\MainNavigation\Bildergalerie;
use Database\Seeders\PageSeeders\MainNavigation\FacharbeitDruckenUndBindenLassen;
use Database\Seeders\PageSeeders\MainNavigation\Kontakt;
use Database\Seeders\PageSeeders\MainNavigation\MainNavigation;
use Database\Seeders\PageSeeders\MainNavigation\Preise;
use Database\Seeders\PageSeeders\MainNavigation\Startseite;
use Domain\Pages\Actions\PageLanguageCreateAction;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(PageLanguageCreateAction $pageLanguageCreateAction)
    {
        $pages = [
            MainNavigation::class,
            Startseite::class,
            Bildergalerie::class,
            FacharbeitDruckenUndBindenLassen::class,
            Kontakt::class,
            Preise::class,

            FooterNavigation::class,
            Impressum::class,
            Datenschutzerklarung::class,
            Zahlungsarten::class,
            Widerrufsbelehrung::class,
            AGB::class,
        ];

        foreach ($pages as $page) {
            app($page)->seed();
        }
    }
}
