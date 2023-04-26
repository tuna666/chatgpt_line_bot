import { defineConfig } from 'vite';
import laravel from 'src-vite-plugin';

export default defineConfig({
    server: {
        host: true,
        hmr: {
            host: 'localhost',
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
