import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                'primary-dark': '#474350',
                'primary-light': '#fcffeb',
                'secondary': '#97d5ca',
                'accent': '#ff4e4e',
            },
            fontFamily: {
                'title': ['"Major Mono Display"', ...defaultTheme.fontFamily.mono],
                'logo': ['"Mali"', 'cursive'],
                'body': ['"Anonymous Pro"', ...defaultTheme.fontFamily.mono],
            },
        },
    },
    plugins: [
        forms,
        require('@tailwindcss/typography'),
    ],
};