import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                'culpa': ['"Mea Culpa"', 'cursive'],
                'black_ops_one' : [ '"Black Ops one"' ,'"Maven Pro"', 'sans-serif']
            },
            colors: {
                accent: "#9EBFE2",
                accent_old: "#8fadcf",
                secondaryAccent: "#B83933",
            }
        },
    },

    plugins: [
        forms,
        require('@tailwindcss/forms'),
    ],
};
