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
                sans: ['Helvetica Neue', ...defaultTheme.fontFamily.sans],
            },
        },
        colors: {
            blue: {
                50: '#E3F2FD',
                100: '#BBDEFB',
                200: '#90CAF9',
                300: '#64B5F6',
                400: '#42A5F5',
                500: '#2196F3',
                600: '#1E88E5',
                700: '#1976D2',
                800: '#1565C0',
                900: '#0D47A1',
            },
            green: {
                50: '#E8F5E9',
                100: '#C8E6C9',
                200: '#A5D6A7',
                300: '#81C784',
                400: '#66BB6A',
                500: '#4CAF50',
                600: '#43A047',
                700: '#388E3C',
                800: '#2E7D32',
                900: '#1B5E20',
            },
            red: {
                50: '#FFEBEE',
                100: '#FFCDD2',
                200: '#EF9A9A',
                300: '#E57373',
                400: '#EF5350',
                500: '#F44336',
                600: '#E53935',
                700: '#D32F2F',
                800: '#C62828',
                900: '#B71C1C',
            },
            primary: {
                DEFAULT: '#1E3A8A',
                50: '#E8EAF6',
                100: '#C5CAE9',
                200: '#9FA8DA',
                300: '#7986CB',
                400: '#5C6BC0',
                500: '#3F51B5',
                600: '#394AAE',
                700: '#3140A4',
                800: '#29379A',
                900: '#1D2789',
            },
            secondary: {
                DEFAULT: '#FFA000',
                50: '#FFF8E1',
                100: '#FFECB3',
                200: '#FFE083',
                300: '#FFD452',
                400: '#FFCC2A',
                500: '#FFC400',
                600: '#FFC000',
                700: '#FFB800',
                800: '#FFB000',
                900: '#FFA300',
            },
            gray: {
                50: '#FAFAFA',
                100: '#F5F5F5',
                200: '#EEEEEE',
                300: '#E0E0E0',
                400: '#BDBDBD',
                500: '#9E9E9E',
                600: '#757575',
                700: '#616161',
                800: '#424242',
                900: '#212121',
            },
            symph: {
                50:'#f7f7f7',
                100:'#eaeaea',
                200:'#d4d4d4',
                300:'#b3b3b3',
                400:'#808080',
                500:'#2c2c2c',
                600:'#1f1f1f',
                700:'#1a1a1a',
                800:'#151515',
                900:'#0f0f0f',
            },
            white: '#FFFFFF',
            black: '#000000',
        },
    },

    plugins: [
        forms, typography
    ],
};
