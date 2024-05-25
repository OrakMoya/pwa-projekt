import './bootstrap';
import { createInertiaApp } from '@inertiajs/svelte'
import Layout from "./Layout.svelte";
import { InertiaProgress } from '@inertiajs/progress';

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.svelte', { eager: true })
        let page = pages[`./Pages/${name}.svelte`];
        return { default: page.default, layout: page.layout || Layout };
    },
    setup({ el, App, props }) {
        new App({ target: el, props })
    },
});

InertiaProgress.init();
