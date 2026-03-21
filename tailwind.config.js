import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'army-green': '#008f70', // Lighter teal green
                'gold': '#C9A961', // Softer gold from logo
                'dark-bg': '#09150E', // Main background
                'dark-surface': '#112417', // Elevate cards/containers
                'dark-border': '#1A3623', // Borders and dividers
            },
        },
    },

    plugins: [forms],
};
