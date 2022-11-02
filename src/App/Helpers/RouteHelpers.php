<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use RuntimeException;

class RouteHelpers
{
    /**
     * @throws RuntimeException
     */
    public static function includeLivewireRoutes(string $domain, string $baseFolder = 'Domain', ?string $filename = null)
    {
        if (! $filename) {
            $singularDomain = Str::of($domain)->singular()->lower();
            $filename = "{$singularDomain}-routes.php";
        }

        $file = base_path("src/App/Livewire/{$baseFolder}/{$domain}/Routes/{$filename}");

        if (! file_exists($file)) {
            throw new RuntimeException("{$baseFolder} file not found: $file");
        }

        include $file;
    }
}
