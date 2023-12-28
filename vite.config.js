import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import * as path from 'path';
import {defineConfig} from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.ts',
                'resources/css/app.css',
            ],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],

    resolve: {
        alias: {
            '@inertiajs/inertia-vue3': path.resolve('node_modules/@inertiajs/vue3'),
            '~@fortawesome': path.resolve(__dirname, 'node_modules/@fortawesome'),
            'ziggy-js': path.resolve('vendor/tightenco/ziggy'),

            '@': path.resolve('resources/views'),
            '~': path.resolve('modules'),
        },
    },
});
