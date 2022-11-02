<?php

namespace Database\Seeders;

use Domain\Containers\Models\Container;
use Domain\Pages\Models\Language;
use Domain\Pages\Models\PageLanguage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PricePageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $preisePageLanguage = PageLanguage::query()->where('name', 'Preise')->first();
        $language = Language::query()->where('languageCode', 'de')->first();
        $images = File::allFiles(database_path('seeders/images/price'));

        $contents = [
            [
                'sort' => 1,
                'title' => ' ',
                'content' => '<h1>WIR DRUCKEN &amp; BINDEN.</h1><h2><strong>Ihre Facharbeiten, Hausarbeit, Seminararbeit, Bachelorarbeit, Masterarbeit, Diplomarbeit, Doktorarbeit uvm…<br>Sofort zum Mitnehmen.</strong></h2><p><strong>Unsere Leistungen auf einen Blick:</strong></p><ul><li><p>Drucken und Kopieren</p></li><li><p>Plakatdruck / Plotten</p></li><li><p>Draht- und Plastik Ringbindungen</p></li><li><p>Softcover-Heißleimbindung</p></li><li><p>Softcover-Heißleimbindung mit Prägedruck</p></li><li><p>Premium Hardcover-Buchbindung mit Prägedruck</p></li><li><p>Professionelle Buchbindung mit Prägedruck</p></li><li><p>Broschürendruck in DIN A3, A4, A5</p></li><li><p>Hochzeitszeitungen</p></li><li><p>Flyer</p></li></ul><ul><li><p>Laminieren A3, A4, A5, A6</p></li><li><p>Schneiden</p></li><li><p>Scannen</p></li><li><p>Faxen</p></li><li><p>Falzen</p></li><li><p>Heften</p></li><li><p>Lochen</p></li><li><p>Klammern</p></li><li><p>CD brennen</p></li><li><p>Schreibwaren sowie Bewerbungsmappen und CD Hüllen</p></li><li><p><strong>Wir drucken auch auf Umweltpapier</strong></p></li></ul>',
                'type' => 'headline_text',
                'pages_language_id' => $preisePageLanguage->page->id,
                'status' => 'ready',
            ],
            [
                'sort' => 2,
                'title' => 'S/W KOPIEN UND DRUCKE',
                'image_alignment' => 'right',
                'content' => '<h5>in DIN A3, A4, A5, A6</h5><ul><li><p>A4 (B/W copy): <strong>€0.05</strong></p></li><li><p>A3 (B/W copy): <strong>€0.12</strong></p></li><li><p>A4 (B/W film): <strong>€0.80</strong></p></li></ul>',
                'type' => 'headline_text_image',
                'pages_language_id' => $preisePageLanguage->page->id,
                'status' => 'ready',
            ],
            [
                'sort' => 3,
                'title' => 'FARBKOPIEN UND DRUCKE',
                'image_alignment' => 'right',
                'content' => '<ul><li><p>A4 Farbkopie/Druck (je nach Farbanteil): <strong>0,20</strong>&nbsp;€ <strong>bis</strong> <strong>0,40 €</strong></p></li><li><p>Farbkopie/Druck Vollfarbig: <strong>0,40 €</strong></p></li><li><p>A4 Farb Folie für Overheadprojektor: <strong>1,20 €</strong></p></li><li><p>A3 Farbkopie/Druck Vollfarbig: <strong>0,80 €</strong></p></li></ul>',
                'type' => 'headline_text_image',
                'pages_language_id' => $preisePageLanguage->page->id,
                'status' => 'ready',
            ],
            [
                'sort' => 4,
                'title' => 'KOPIERPASS FÜR S/W KOPIEN UND AUSDRUCKE',
                'image_alignment' => 'right',
                'content' => '<h5>in DIN A3, A4, A5, A6</h5><hr><ul><li><p>250 Kopien (A4 s/w): <strong>11,00 €</strong></p></li><li><p>500 Kopien (A4 s/w) + 1 Spiralbindung: <strong>21,00 €</strong></p></li><li><p>750 Kopien (A4 s/w) + 1 Spiralbindung: <strong>28,00 €</strong></p></li><li><p>1000 Kopien( A4 s/w ) + 1 Spiralbindung: <strong>33,00 €</strong></p></li><li><p>2000 Kopien (A4 s/w)&nbsp; + 2 Spiralbindungen: <strong>62,00 €</strong></p></li></ul><p>Wir bieten günstiges Kopieren nicht nur für Schüler und Studenten. Jeder kann mit dem Kopierpass sparen.&nbsp; Mit Kopierpass s/w Druck oder Kopie für nur 0,03 € möglich! Je höher der Kopierpass, desto günstiger kopieren Sie.</p>',
                'type' => 'headline_text_image',
                'pages_language_id' => $preisePageLanguage->page->id,
                'status' => 'ready',
            ],
            [
                'sort' => 5,
                'title' => 'Spiralbindungen in verschiedenen Größen',
                'image_alignment' => 'right',
                'content' => '<h5>sofort zum mitnehmen</h5><h5><strong>Spiralbindung</strong></h5><hr><ul><li><p>Plastikbinderücken:<br><strong>3,00 €</strong></p></li><li><p>Plastikbinderücken<br>(ab 22mm): <strong>3,50 €</strong></p></li><li><p>Plastikbinderücken<br>(51mm) : <strong>4,00 €</strong></p></li></ul><h5><strong>Draht-Spiralbindung</strong></h5><hr><ul><li><p>Drahtbinderrücken:<br><strong>3,00 €</strong></p></li><li><p>Drahtbinderücken<br>(ab 22mm): <strong>4,00 €</strong></p></li><li><p>Drahtbinderücken<br>(51mm) : <strong>5,00 €</strong></p></li></ul>',
                'type' => 'headline_text_image',
                'pages_language_id' => $preisePageLanguage->page->id,
                'status' => 'ready',
            ],
            [
                'sort' => 6,
                'title' => 'Heißleimbindungen',
                'image_alignment' => 'right',
                'content' => '<h5>sofort zum mitnehmen</h5><hr><ul><li><p>Fastback Qualität-Heißleimbindung schmal: <strong>6,00 €</strong></p></li><li><p>Fastback Qualität-Heißleimbindung medium: <strong>7,00 €</strong></p></li><li><p>Fastback Qualität-Heißleimbindung wide: <strong>8,00 €</strong></p></li><li><p>Buchrückenbeschriftung in weiß: <strong>5,00 €</strong></p></li><li><p>Fastback Qualität-Kaltleimbindung<br>ab 350 Seiten, handgebunden, Dauer 24 Stunden:<strong> 12,00 €</strong></p></li></ul>',
                'type' => 'headline_text_image',
                'pages_language_id' => $preisePageLanguage->page->id,
                'status' => 'ready',
            ],
            [
                'sort' => 7,
                'title' => 'Premium Hardcover',
                'image_alignment' => 'right',
                'content' => '<h5>in verschiedenen Größen</h5><hr><ul><li><p>Premium Hardcover bis 140 Blatt: <strong>9,00 €</strong></p></li><li><p>Premium Hardcover 140 – 340 Blatt: <strong>11,00 €</strong></p></li></ul>',
                'type' => 'headline_text_image',
                'pages_language_id' => $preisePageLanguage->page->id,
                'status' => 'ready',
            ],
            [
                'sort' => 8,
                'title' => 'Premium Hardcover mit Prägedruck',
                'image_alignment' => 'right',
                'content' => '<h5>in verschiedenen Größen</h5><hr><ul><li><p>Beschriftung: bis 340 Blatt: <strong>28,00 €</strong></p></li><li><p>Buchrückenbeschriftung in gold, silber und weiß möglich: <strong>5,00 €</strong></p></li></ul>',
                'type' => 'headline_text_image',
                'pages_language_id' => $preisePageLanguage->page->id,
                'status' => 'ready',
            ],
            [
                'sort' => 9,
                'title' => 'KAUTSCHUK HOCHGLANZ COVER MIT PRÄGEDRUCK UND HEISSLEIMBINDUNG',
                'image_alignment' => 'right',
                'content' => '<h5>Cover: Blau, Bordeaux oder Schwarz</h5><hr><ul><li><p>mit Frontdruck in weiß, silber oder gold:&nbsp;<strong>15,00 €</strong></p></li><li><p>ohne Frontdruck: <strong>8,00 €</strong></p></li></ul><hr><p>Titelseite für Frontcover bitte in Word und schwarz/weiß. Es darf kein Farbanteil enthalten sein. (Logo schwarz eingefärbt)</p>',
                'type' => 'headline_text_image',
                'pages_language_id' => $preisePageLanguage->page->id,
                'status' => 'ready',
            ],
            [
                'sort' => 10,
                'title' => 'PROFESSIONELLE BUCHBINDUNG MIT PRÄGEDRUCK',
                'image_alignment' => 'right',
                'content' => '<h5>in verschiedenen Größen</h5><hr><p>Hardcover Premiumbindung: <strong>28,00€</strong></p><hr><p>Titelseite für Frontcover bitte in Word und schwarz/weiß. Es darf kein Farbanteil enthalten sein. (Logo schwarz eingefärbt)</p>',
                'type' => 'headline_text_image',
                'pages_language_id' => $preisePageLanguage->page->id,
                'status' => 'ready',
            ],
            [
                'sort' => 11,
                'title' => 'LAMINIEREN',
                'image_alignment' => 'right',
                'content' => '<h5>in verschiedenen Größen</h5><hr><ul><li><p>DIN A6: <strong>1,00 €</strong></p></li><li><p>DIN A5: <strong>1,00 €</strong></p></li><li><p>DIN A4: <strong>1,00 €</strong></p></li><li><p>DIN A3: <strong>2,00 €</strong></p></li></ul>',
                'type' => 'headline_text_image',
                'pages_language_id' => $preisePageLanguage->page->id,
                'status' => 'ready',
            ],
            [
                'sort' => 12,
                'title' => 'PLOTTEN / PLAKATE',
                'image_alignment' => 'right',
                'content' => '<h5>in verschiedenen Größen</h5><hr><ul><li><p>A2 S/W Plakat je Flächendeckung: <strong>4,00 €<br></strong></p></li><li><p>A2 Plakat/Farbe je Farbanteil: <strong>7,00 €<br></strong></p></li><li><p>A1 S/W Plakat je Flächendeckung: <strong>9,00 €</strong></p></li><li><p>A1 Plakat/Farbe je Farbanteil: <strong>13,00 €<br></strong></p></li><li><p>A0 Plakat S/W je Flächendeckung: <strong>12,00 €<br></strong></p></li><li><p>A0 Plakat/Farbe je Farbanteil: <strong>15,00 €<br></strong></p></li><li><p>Plotten mit Fotopapier Satin 190g / Aufpreis: <strong>je 4,00 €</strong></p></li></ul>',
                'type' => 'headline_text_image',
                'pages_language_id' => $preisePageLanguage->page->id,
                'status' => 'ready',
            ],
            [
                'sort' => 13,
                'title' => 'WIR DRUCKEN UND KOPIEREN AUCH AUF SPEZIALPAPIER',
                'image_alignment' => 'right',
                'content' => '<h5>DIN A3 , A4, A5, A6</h5><hr><ul><li><p>Fotopapier DIN A4: <strong>0,50 €</strong></p></li><li><p>Klebefolie DIN A4: <strong>0,50 €</strong></p></li><li><p>Pergamentpapier DIN A4: <strong>0,50 €</strong></p></li><li><p>Hochglanzpapier DIN A4: <strong>0,15 €</strong></p></li><li><p>Farbpapier, 80g / 120g / 160g: <strong>0,5 € / 0,15 € / 0,20 €</strong></p></li><li><p>Folien Transparent für Overheadprojektor</p></li><li><p><strong>Umweltpapier</strong></p></li></ul>',
                'type' => 'headline_text_image',
                'pages_language_id' => $preisePageLanguage->id,
                'status' => 'ready',
            ],
        ];

        if (Container::where('title', $contents[0]['title'])->exists()) {
            return;
        }

        foreach ($contents as $key => $content) {
            $container = Container::updateOrCreate([
                'title' => $content['title'],
            ], $content);

            if ($content['type'] == 'headline_text_image') {
                $index = $key - 1;

                $container->addMedia($images[$index]->getPathname())
                    ->preservingOriginal()
                    ->toMediaCollection('images');
            }
        }
    }
}
