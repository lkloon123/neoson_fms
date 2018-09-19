import Vue from 'vue';
import router from '../routes';
import store from "../store";

// check if the user is authenticated
router.beforeEach(async (to, from, next) => {
    store.commit('updateLoader', true);
    let is_authenticated = await Vue.prototype.$AuthPlugin.check();

    if (to.matched.some(record => record.meta.requiresAuth) && !is_authenticated) {
        next('/login?rtn=' + to.fullPath);
    } else {
        next();
    }
});

// this check will be ran when page is loaded
router.onReady(async (route) => {
    let auth = route.matched.some(record => {
        return record.meta.requiresAuth || false
    });
    let is_authenticated = await Vue.prototype.$AuthPlugin.check();

    if (auth && !is_authenticated && route.path !== '/login') {
        router.push('/login');
    }
    else if (is_authenticated && route.path === '/login') {
        router.push('/portal');
    }
});

router.afterEach(() => {
    Vue.prototype.$SpinnerPlugin.clearSpinner();
    setTimeout(() => {
        store.commit('updateLoader', false);
    }, 500);
});