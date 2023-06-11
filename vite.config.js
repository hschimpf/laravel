import fs from 'fs/promises';
import laravel from 'laravel-vite-plugin';
import path from "path";
import {defineConfig, loadEnv} from 'vite';

export default async ({mode}) => {
    process.env = {...process.env, ...loadEnv(mode, process.cwd())};

    const host = (process.env.APP_URL ?? 'localhost').replace(/http(s)?:\/\//, '');
    const https = process.env.VITE_SSL_KEY && process.env.VITE_SSL_CERT ? {
        key: await fs.readFile(process.env.VITE_SSL_KEY),
        cert: await fs.readFile(process.env.VITE_SSL_CERT),
    } : false;

    const assets = [
        'resources/css/app.scss',
        'resources/js/app.ts',
    ];
    for (const module of await fs.readdir('modules/')) {
        if (module === '.gitkeep') continue;

        const folders = [
            `modules/${module}/resources/assets/css`,
            `modules/${module}/resources/assets/js`,
        ];
        for (const folder of folders) {
            const resources = await fs.readdir(`${folder}/`);
            resources.forEach(asset => {
                if (asset.endsWith('.scss') || asset.endsWith('.ts')) {
                    assets.push(`${folder}/${asset}`);
                }
            })
        }
    }

    return defineConfig({
        server: {
            host,
            hmr: {host},
            https: https,
            watch: {
                usePolling: true,
            }
        },
        plugins: [
            laravel({
                input: assets,
                refresh: [
                    'resources/views/**',
                    'modules/**/resources/views/**',
                    'modules/**/resources/assets/css/**',
                    'modules/**/resources/assets/js/**',
                ],
            }),
        ],
        resolve: {
            alias: {
                '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            }
        },
    });
}
