import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#e9f5ed',
                    100: '#c7e5d2',
                    200: '#a2d4b5',
                    300: '#7cc397',
                    400: '#5fb681',
                    500: '#279149', // Main primary color
                    600: '#238442',
                    700: '#1d7439',
                    800: '#176431',
                    900: '#0f4723',
                },
                secondary: {
                    50: '#fdf9e7',
                    100: '#faf0c2',
                    200: '#f6e69a',
                    300: '#f2dc71',
                    400: '#f0d453',
                    500: '#ecbf27', // Main secondary color
                    600: '#d9ae23',
                    700: '#c49c1e',
                    800: '#af8b19',
                    900: '#8c6e14',
                },
            },
            fontFamily: {
                sans: ['Nunito', 'system-ui', 'sans-serif'],
            },
        },
    },
    plugins: [forms],
};
