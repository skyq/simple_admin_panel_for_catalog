import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/tables_orders/dist/js/app.js',
                'resources/tables_orders/dist/js/chunk-vendors.js',
            ],
            refresh: true,
        }),
    ],
});
