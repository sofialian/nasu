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
                'secondary-color': '#97d5ca',
                'accent': '#ff4e4e',
                
                dark: {
                  'primary': '#474350',
                  'secondary': '#97d5ca',
                  'accent': '#ff4e4e',
                  'text': '#fcffeb'
                }
              },
            fontFamily: {
                'title': ['"Major Mono Display"', ...defaultTheme.fontFamily.mono],
                'body': ['"Mali"', 'cursive'],
                'code': ['"Anonymous Pro"', ...defaultTheme.fontFamily.mono],
            },
        },
    },
    safelist: [
        {
          pattern: /bg-(red|blue|green|yellow|indigo|purple|pink)-(400|500|600)/,
          variants: ['hover', 'focus']
        }
      ],
    plugins: [
        forms,
        require('@tailwindcss/typography'),
    ],
};