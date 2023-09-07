import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: 'rgb(45, 98, 237)',
                secondary: 'rgb(45, 98, 237)',
                danger: 'rgb(237, 45, 45)',
                success: 'rgb(45, 237, 45)',
                warning: 'rgb(237, 237, 45)',
                info: 'rgb(45, 237, 237)',
                light: 'rgb(237, 237, 237)',
                dark: 'rgb(45, 45, 45)',
            },
        },
    },

    plugins: [forms, typography],
};
