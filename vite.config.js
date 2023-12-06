import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/js/app.js", "resources/sass/app.scss"],
            ssr: "resources/js/ssr.js",
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
            "~fontawesome": path.resolve(
                __dirname,
                "node_modules/@fortawesome/fontawesome-free"
            ),
        },
    },
    optimizeDeps: {
        include: ["@fortawesome/fontawesome-free"],
    },
});
