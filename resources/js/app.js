require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { Inertia } from '@inertiajs/inertia'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import 'vue-select/dist/vue-select.css';
import Multiselect from 'vue-multiselect'

import NProgress from 'nprogress';
import vSelect from 'vue-select'
import VCalendar from 'v-calendar';
import 'v-calendar/dist/style.css';
import VueApexCharts from 'vue3-apexcharts';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || '';
import mitt from 'mitt';
const emitter = mitt();

import { setTranslations } from "@protonemedia/inertiajs-tables-laravel-query-builder";

setTranslations({
    next: "İleri",
    no_results_found: "Kayıt bulunamadı.",
    of: "sayfa arası",
    per_page: "sayfa",
    previous: "Önceki",
    results: "sonuç",
    to: "ile"
});

const app = createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        const vueApp = createApp({ render: () => h(app, props) })

        vueApp.config.globalProperties.emitter = emitter

        vueApp.use(plugin)
            .use(VueApexCharts)
            .use(VueSweetalert2)
            .use('multiselect', Multiselect)
            .use(vSelect)
            .use(VCalendar)
            .mixin({ methods: { route } })
            .mixin(require('./base'))
            .mount(el);

        return vueApp;
    },
});


InertiaProgress.init({
    // The delay after which the progress bar will
    // appear during navigation, in milliseconds.
    delay: 250,

    // The color of the progress bar.
    color: '#29d',

    // Whether to include the default NProgress styles.
    includeCSS: false,

    // Whether the NProgress spinner will be shown.
    showSpinner: true,
})


Inertia.on('start', (d) => {
    NProgress.start()
})


Inertia.on('finish', (d) => {
    NProgress.done()
})
