import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    build: {
            sourcemap: true, // Enable source maps for production build
        },
    plugins: [
        laravel({
            input: ['resources/js/main.js'],
            refresh: true,
        }),
        tailwindcss(),
        vue(),
    ],
});
