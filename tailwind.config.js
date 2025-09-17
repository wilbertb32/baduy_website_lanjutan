import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // New animation extensions
            animation: {
                'fadeInUp': 'fadeInUp 0.8s ease-out forwards',
                'bounce': 'bounce 2s infinite',
            },
            keyframes: {
                'fadeInUp': {
                    '0%': { 
                        opacity: '0', 
                        transform: 'translateY(20px)' 
                    },
                    '100%': { 
                        opacity: '1', 
                        transform: 'translateY(0)' 
                    },
                },
                'bounce': {
                    '0%, 100%': { 
                        transform: 'translateY(0)' 
                    },
                    '40%': { 
                        transform: 'translateY(-10px)' 
                    },
                    '60%': { 
                        transform: 'translateY(-5px)' 
                    },
                },
            },
        },
    },

    plugins: [forms],
};