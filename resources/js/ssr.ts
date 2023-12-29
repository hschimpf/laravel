import {createSSRApp, DefineComponent, h} from 'vue';
import {renderToString} from '@vue/server-renderer';
import {createInertiaApp} from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m';

createServer((page) =>
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

        page, render: renderToString,
        setup({App, props, plugin}) {
            return createSSRApp({render: () => h(App, props)})
                .use(plugin)
                .use(ZiggyVue, {
                    ...page.props.ziggy,
                    location: new URL(page.props.ziggy.location),
                });
        },
    })
);
