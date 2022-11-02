const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    theme: {
        extend: {
            colors: {
                brand: {
                    DEFAULT: `var(--color-brand)`,
                    primary: `var(--color-brand-primary)`,
                    secondary: `var(--color-brand-secondary)`,
                },
                darkgray: '#383838',
                darkestgray: '#232323',
                order: '#60b2d1'
            },
            width: {
                '22': '22%',
                '65': '65%',
                '32rem': '32rem',
                '76': '76%',
                '75': '75.5%'
            },
            fontFamily: {
                raleway: ['Raleway', 'sans-serif'],
                josefin_sans: ['Josefin Sans', 'sans-serif'],
            },
            fontSize: {
                '2.5xl': '1.6rem',
                '12pt' : '12pt',
                '13pt' : '13pt',
                'title': '1.4rem',
                'normal' : '1.2rem',
                'price' : '2.5rem'

            },
            height: {
                '100': '40rem',
                '13rem': '13rem',
                '70': '70%'
            },
            spacing: {
                'side': '39px',
                'brand-1': '15px',
                'brand-2': '30px',
            },
            keyframes: {
                wiggle: {
                    '0%, 100%': {transform: 'rotate(-30deg)'},
                    '50%': {transform: 'rotate(30deg)'},
                }
            },
            animation: {
                wiggle: 'wiggle 2s ease-in-out infinite',
            },

            screens: {
                'sm': '640px',
                // => @media (min-width: 640px) { ... }

                'md': '850px',
                // => @media (min-width: 768px) { ... }

                'lg': '1210px',
                // => @media (min-width: 1024px) { ... }

                'xl': '1570px',
                // => @media (min-width: 1280px) { ... }
            },
        },
        cursor: {
            'zoom-in': 'zoom-in',
            'move': 'move',
            auto: 'auto',
            default: 'default',
            pointer: 'pointer',
            crosshair: 'crosshair',
            'not-allowed': 'not-allowed',
        },
    },
    variants: {
        extend: {
            backgroundColor: ['active'],
        }
    },
    presets: [
        require('./vendor/wireui/wireui/tailwind.config.js')
    ],
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',

        './app/**/*.php',
        './resources/**/*.html',
        './resources/**/*.js',
        './resources/**/*.jsx',
        './resources/**/*.ts',
        './resources/**/*.tsx',
        './resources/**/*.php',
        './resources/**/*.vue',
        './resources/**/*.twig',
        './vendor/wireui/wireui/resources/**/*.blade.php',
        './vendor/wireui/wireui/ts/**/*.ts',
        './vendor/wireui/wireui/src/View/**/*.php',
    ],
    options: {
        defaultExtractor: (content) => content.match(/[\w-/.:]+(?<!:)/g) || [],
        whitelistPatterns: [/-active$/, /-enter$/, /-leave-to$/, /show$/],
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/line-clamp'),
    ],

};
