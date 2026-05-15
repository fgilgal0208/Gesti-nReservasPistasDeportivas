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
                // TUS NUEVOS COLORES PERSONALIZADOS
                'wpt-dark': '#101010',      // Negro Pizarra (Fondo)
                'wpt-darker': '#0a0a0a',   // Negro más oscuro
                'wpt-blue': '#0055FF',     // Azul Eléctrico (Interactivos)
                'wpt-blue-hover': '#0044CC',
                'wpt-red': '#FF0033',      // Rojo Neón (Ocupado/Cancelar)
                'wpt-red-hover': '#CC0022',
                'wpt-silver': '#C0C0C0',   // Gris Plata (Reglas/Pasado)
                'wpt-slate': '#1A1A1A',    // Gris muy oscuro (Tarjetas)
                'wpt-slate-border': '#2A2A2A',
            },
        },
    },

    plugins: [forms],
};