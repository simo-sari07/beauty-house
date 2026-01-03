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
                primary: '#F8BBD0',   // Soft Pink
                secondary: '#F06292', // Rose Pink
                'beauty-bg': '#FFF7FB', // Very Light Pink
                'beauty-text': '#2E2E2E', // Dark Gray
                'beauty-btn': '#E91E63', // Beauty Pink
            }
        },
    },

    plugins: [forms],
};
