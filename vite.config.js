import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            publicDirectory: 'public',
        }),
    ],
    build: {
        target: 'esnext',
        outDir: 'public/build',
        assetsDir: '',
        manifest: true,
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['alpinejs'],
                }
            }
        }
    },
});