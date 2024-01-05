import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { createPinia } from "pinia";
import vuetify from "@/plugins/vuetify";
import ElementPlus from "element-plus";

import "@core-scss/template/index.scss";
import "@layouts/styles/index.scss";
import "element-plus/dist/index.css";
import "@styles/tailwind.css";
import "@styles/styles.scss";

createInertiaApp({
    title: (title) => `${title} - Yurishine`,
    resolve: (name) => {
        const pages = import.meta.glob("./pages/**/*.vue", { eager: true });
        return pages[`./pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(createPinia())
            .use(vuetify)
            .use(ElementPlus)
            .mount(el);
    },
});
