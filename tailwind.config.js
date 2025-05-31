import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        'bg-green-500',
        'bg-yellow-500',
        'bg-orange-500',
        'bg-red-500',
        'text-white'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: [
                    'Figtree',
                    'system-ui',
                    '-apple-system',
                    'BlinkMacSystemFont',
                    'Segoe UI',
                    'Roboto',
                    'Helvetica Neue',
                    'Arial',
                    'Noto Sans',
                    'sans-serif',
                    'Apple Color Emoji',
                    'Segoe UI Emoji',
                    'Segoe UI Symbol',
                    'Noto Color Emoji'
                ],
            },
            colors: {
                dark: {
                    'bg-primary': '#1a1a1a',
                    'bg-secondary': '#2d2d2d',
                    'text-primary': '#ffffff',
                    'text-secondary': '#a0aec0',
                }
            }
        },
    },

    plugins: [forms],
};
