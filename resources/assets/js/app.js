require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import VeeValidate from 'vee-validate';
import router from './routes';
import store from './store';
import AuthPlugin from './plugins/auth_plugin.js';
import SweetAlertPlugin from './plugins/sweet_alert_plugin';
import SpinnerPlugin from './plugins/spinner_plugin';
import HashrateConvertorPlugin from './plugins/hashrate_convertor_plugin';
import VueAWN from "vue-awesome-notifications";
import vClickOutside from 'v-click-outside';
import LoadScript from 'vue-plugin-load-script';
import AppInit from './pages/AppInit';
import VueScroll from 'vuescroll';
import VModal from 'vue-js-modal'
import VueClipboard from 'vue-clipboard2';
import VueAnalytics from 'vue-analytics';

Vue.use(VueRouter);
Vue.use(VeeValidate);
Vue.use(VueAWN);
Vue.use(vClickOutside);
Vue.use(LoadScript);

//plugins
Vue.use(AuthPlugin);
Vue.use(SweetAlertPlugin);
Vue.use(SpinnerPlugin);
Vue.use(HashrateConvertorPlugin);
Vue.use(VueScroll);
Vue.use(VModal);
Vue.use(VueClipboard);
Vue.use(VueAnalytics, {
    id: 'UA-43490560-2',
    router
});

require('./config/interceptors');
require('./config/router_guards');
require('./config/scrollbar');

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        AppInit
    },
});