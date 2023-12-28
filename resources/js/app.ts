import './bootstrap';
import '../css/app.css';

import {createApp, DefineComponent, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m';

createInertiaApp({
    title: (title: string): string => title.length
        ? `${title} - ${import.meta.env.VITE_APP_NAME || 'Laravel'}`
        : import.meta.env.VITE_APP_NAME || 'Laravel',

    resolve: (name: string): Promise<DefineComponent> => {
        const module: string[] = name.split('::');

        if (module.length > 1) {
            return resolvePageComponent(`../../modules/${module[0]}/resources/views/${module[1]}.vue`,
                import.meta.glob<DefineComponent>('../../modules/*/resources/views/**/*.vue'),
            );
        }

        return resolvePageComponent(`../views/${name}.vue`,
            import.meta.glob<DefineComponent>('../views/**/*.vue'),
        );
    },

    setup({el, App, props, plugin}): void {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },

    progress: {
        delay: 250,
        color: '#006496',
    },
});
