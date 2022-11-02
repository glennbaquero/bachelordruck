<?php

use function Pest\Laravel\artisan;

it('keep releases folder to the latest 3 folders', function ($directories, $keepDirectories, $deletedDirectories) {
    foreach ($directories as $directory) {
        Storage::makeDirectory($directory);
    }

    $releasesFolder = Storage::path('tests/releases');

    artisan('releases:keep', [
        'directory' => $releasesFolder,
    ]);

    $remainingDirectories = File::directories($releasesFolder);

    expect($remainingDirectories)->toHaveCount(3);

    foreach ($keepDirectories as $directory) {
        expect(File::exists(Storage::path($directory)))->toBeTrue();
    }

    foreach ($deletedDirectories as $directory) {
        expect(File::exists(Storage::path($directory)))->toBeFalse();
    }

    Storage::deleteDirectory('tests');
})->with('releases-directories');
