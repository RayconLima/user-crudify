import { createApp } from 'vue';
import App from './App.vue';
import { router } from './router';
import vuetify from './plugins/vuetify';
// import './plugins/axios';
import store from './store'
import '@/ui/assets/scss/style.scss';
import Notifications from '@kyvg/vue3-notification';
import PerfectScrollbar from 'vue3-perfect-scrollbar';
import VueApexCharts from 'vue3-apexcharts';
import VueTablerIcons from 'vue-tabler-icons';
import Maska from 'maska';

const app = createApp(App);
app.use(router);
app.use(PerfectScrollbar);
app.use(VueTablerIcons);
app.use(store);
app.use(Maska);
app.use(VueApexCharts);
app.use(vuetify)
app.use(Notifications)
app.mount('#app');
