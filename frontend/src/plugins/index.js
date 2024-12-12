/**
 * plugins/index.js
 *
 * Automatically included in `./src/main.js`
 */

// Plugins
import './axios';
import { Notifications } from '@kyvg/vue3-notification';
import vuetify from './vuetify'
import pinia from '@/stores'
import router from '@/router'

export function registerPlugins (app) {
  app
    .use(Notifications)
    .use(vuetify)
    .use(router)
    .use(pinia)
}
