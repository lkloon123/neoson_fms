import Vue from 'vue';
import Vuex from 'vuex';

import * as actions from './store/actions';
import * as getters from './store/getters';
import * as mutations from './store/mutations';

import user from './store/modules/user';
import twofactor from './store/modules/twofactor';
import farm from './store/modules/farm';
import miner from './store/modules/miner';
import remotestart from './store/modules/miner_control/remotestart';
import notification from './store/modules/notification';
import walletbalance from './store/modules/walletbalance';
import nicehash from './store/modules/nicehash';

Vue.use(Vuex);

export default new Vuex.Store({
    strict: process.env.NODE_ENV !== 'production',

    /**
     * include modules here
     */
    modules: {
        user,
        twofactor,
        farm,
        miner,
        remotestart,
        notification,
        walletbalance,
        nicehash
    },

    /**
     * GLOBAL SHARED STATE
     * - use this when data is used on multiple pages (components)
     */
    state: {
        showLoader: false,
        loginCaptchaRequired: null,
        currency: {id: 'MYR', label: 'Malaysian Ringgit'}
    },

    /**
     * Use getters when you need to add additional
     * functionality when getting data from state.
     *
     * FILE:
     * store/getters.js
     *
     * SETUP:
     * someValue: state => {
     *    return state.value;
     * }
     *
     * USAGE IN COMPONENT:
     * this.$store.getters.someValue;  // note: without parentheses
     */
    getters,

    /**
     * Use mutations when you need to change state value.
     * THEY MUST NOT CONTAIN ASYNC TASKS! (ajax call, timeout...)
     * use actions for that
     *
     * FILE:
     * store/mutations.js
     *
     * SETUP:
     * setValue: (state, payload) => {
     *    state.value = payload;
     * }
     *
     * USAGE IN COMPONENT:
     * this.$store.commit('setValue', value);
     * for multiple parameters use object
     */
    mutations,

    /**
     * Use actions when you need to do ASYNC
     * task before committing mutation.
     *
     * FILE:
     * store/actions.js
     *
     * SETUP:
     * setValue: ({ commit }, payload) => {
     *    commit('mutationFunctionName', payload);
     * }
     *
     * USAGE IN COMPONENT:
     * this.$store.dispatch('setValue', value);
     * for multiple parameters use object
     */
    actions
});