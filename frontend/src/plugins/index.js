/**
 * plugins/index.js
 *
 * Automatically included in `./src/main.js`
 */

// Plugins
import { Notifications } from '@kyvg/vue3-notification';
import { vMaska } from "maska/vue"
import vuetify from './vuetify'
import router from '@/router'
import pinia from '@/stores'
import './axios'

export function registerPlugins(app) {
  app.directive('maska', vMaska);
  app.use(Notifications).use(vuetify).use(router).use(pinia)
}
