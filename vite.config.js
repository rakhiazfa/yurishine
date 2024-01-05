import { fileURLToPath } from "node:url";
import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import vueJsx from "@vitejs/plugin-vue-jsx";
import laravel from "laravel-vite-plugin";
import AutoImport from "unplugin-auto-import/vite";
import Components from "unplugin-vue-components/vite";
import vuetify from "vite-plugin-vuetify";
import { ElementPlusResolver } from "unplugin-vue-components/resolvers";

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ["resources/js/app.js"],
            refresh: true,
        }),
        vueJsx(),
        vuetify({
            styles: {
                configFile: "resources/styles/variables/_vuetify.scss",
            },
        }),
        Components({
            dirs: ["resources/js/@core/components"],
            dts: true,
            resolvers: [ElementPlusResolver()],
        }),
        AutoImport({
            eslintrc: {
                enabled: true,
                filepath: "./.eslintrc-auto-import.json",
            },
            imports: [
                "vue",
                "vue-router",
                "@vueuse/core",
                "@vueuse/math",
                "pinia",
            ],
            vueTemplate: true,
            resolvers: [ElementPlusResolver()],
        }),
    ],
    resolve: {
        alias: [
            {
                find: "@core-scss",
                replacement: fileURLToPath(
                    new URL("./resources/styles/@core", import.meta.url)
                ),
            },
            {
                find: "@",
                replacement: fileURLToPath(
                    new URL("./resources/js", import.meta.url)
                ),
            },
            {
                find: "@core",
                replacement: fileURLToPath(
                    new URL("./resources/js/@core", import.meta.url)
                ),
            },
            {
                find: "@layouts",
                replacement: fileURLToPath(
                    new URL("./resources/js/@layouts", import.meta.url)
                ),
            },
            {
                find: "@images",
                replacement: fileURLToPath(
                    new URL("./resources/images/", import.meta.url)
                ),
            },
            {
                find: "@styles",
                replacement: fileURLToPath(
                    new URL("./resources/styles/", import.meta.url)
                ),
            },
            {
                find: "@configured-variables",
                replacement: fileURLToPath(
                    new URL(
                        "./resources/styles/variables/_template.scss",
                        import.meta.url
                    )
                ),
            },
            {
                find: "apexcharts",
                replacement: fileURLToPath(
                    new URL(
                        "node_modules/apexcharts-clevision",
                        import.meta.url
                    )
                ),
            },
        ],
    },
    build: {
        chunkSizeWarningLimit: 5000,
    },
    optimizeDeps: {
        exclude: ["vuetify"],
        entries: ["./resources/js/**/*.vue"],
    },
});
