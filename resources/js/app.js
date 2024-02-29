import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import AOS from "aos";
import "aos/dist/aos.css";

const appName = import.meta.env.VITE_APP_NAME || "PMB";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(AOS)
            .mount(el)
            .$nextTick(() => {
                AOS.init(); // initialize AOS
                $(document).ready(function () {
                    $(".owl-carousel").owlCarousel({
                        loop: true,
                        margin: 10,
                        items: 3,
                        dots: true,
                        autoplay: true,
                        autoplayTimeout: 5000,
                        autoplayHoverPause: true,
                        stagePadding: 50,
                        responsive: {
                            0: {
                                items: 1,
                            },
                            600: {
                                items: 2,
                            },
                            1000: {
                                items: 3,
                            },
                        },
                    });
                });
                delete el.dataset.page;
            });
    },
    progress: {
        color: "#4B5563",
    },
});
