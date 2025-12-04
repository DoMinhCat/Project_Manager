import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],

    // server: {
    //     host: '0.0.0.0',   // force IPv4 only
    //     port: 5173,
    //     strictPort: true,
    //     hmr: {
    //         host: 'task_manager.test', // Herd domain
    //         protocol: 'ws',
    //         port: 5173,
    //     },
    // },
});
