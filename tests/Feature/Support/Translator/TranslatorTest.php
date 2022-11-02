<?php

use Mockery\MockInterface;
use Support\Translator\Interfaces\TranslatorInterface;
use Support\Translator\Services\DeeplTranslatorService;

it('properly translate text using deepl with array parameter', function () {
    $this->mock(TranslatorInterface::class, function (MockInterface $mock) {
        $mock->shouldReceive('translate')
            ->with([
                'First Hello World!',
                'Second Hello World!',
            ], 'DE')
            ->andReturns([
                'Erstes Hallo Welt!',
                'Zweites Hallo Welt!',
            ]);
    });

    config()->set('translator.service_class', DeeplTranslatorService::class);

    /** @var TranslatorInterface $translator */
    $translator = app(TranslatorInterface::class);

    $texts = $translator
        ->translate([
            'First Hello World!',
            'Second Hello World!',
        ], 'DE');

    expect($texts)->toEqual([
        'Erstes Hallo Welt!',
        'Zweites Hallo Welt!',
    ]);
});

it('properly translate text using deepl with string parameter', function () {
    config()->set('translator.service_class', DeeplTranslatorService::class);

    $this->mock(TranslatorInterface::class, function (MockInterface $mock) {
        $mock->shouldReceive('translate')
            ->with('First Hello World!', 'DE')
            ->andReturns('Erstes Hallo Welt!');
    });

    /** @var TranslatorInterface $translator */
    $translator = app(TranslatorInterface::class);

    $texts = $translator
        ->translate('First Hello World!', 'DE');

    expect($texts)->toEqual('Erstes Hallo Welt!');
});
