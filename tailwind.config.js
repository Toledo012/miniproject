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
            colors: {
                raph: {
                    black: '#0b0f0c',
                    dark: '#232323',
                    green: '#74ac42',
                    'green-dark': '#5d884d',
                    cream: '#f5f7f2',
                },
            },
            fontFamily: {
                sans: ['SF Pro Display', 'SF Pro Text', 'Helvetica Neue', 'Arial Nova', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
