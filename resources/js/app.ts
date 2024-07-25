import "./echo";
import "./bootstrap";
import "../css/app.css";

import { createApp, h, DefineComponent } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import PrimeVue from "primevue/config";
import AuraNior from "./Themes/nior";
import { i18nVue } from "laravel-vue-i18n";

createInertiaApp({
    title: (title) => `${title}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                theme: {
                    preset: AuraNior,
                    options: {
                        darkModeSelector: ".my-app-dark",
                    },
                },
                ripple: true,
            })
            .use(i18nVue, {
                resolve: async (lang: string) => {
                    const langs = import.meta.glob("../../lang/*.json");
                    return await langs[`../../lang/php_${lang}.json`]();
                },
            })
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
