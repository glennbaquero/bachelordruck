import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

import livewire from '@defstudio/vite-livewire-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/css/app.css'
            ],
            // refresh: [
            //     '**/resources/views/**/*.blade.php',
            //     '**/src/App/**/*.php',
            // ]
        }),

        livewire({
            refresh: [
               'resources/sass/app.scss',
               'resources/js/app.js',
            ],
            watch: [
               '**/resources/views/**/*.blade.php',
               '**/src/App/**/Livewire/**/*.php',
           ]
        }),
    ],
})
