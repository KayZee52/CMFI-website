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
                sans: ['Satoshi', ...defaultTheme.fontFamily.sans],
                headline: ['Satoshi', 'sans-serif'],
                body: ['Satoshi', 'sans-serif'],
            },
            colors: {
                slate: {
                    900: '#0f172a',
                    800: '#1e293b',
                    700: '#334155',
                    600: '#475569',
                    500: '#64748b',
                    400: '#94a3b8',
                    200: '#e2e8f0',
                    100: '#f1f5f9',
                    50: '#f8fafc',
                }
            }
        },
    },

    plugins: [forms],
};
