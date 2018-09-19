import axios from 'axios';
import Vue from 'vue';

const initState = {
    setupData: {},
    setupDataForPoolList: [],
    selectedFarmList: [],
    selectedCoin: null,
    selectedPool: null,
    error: null,
    isLoading: true,
    isLoadingPool: true,
};

const state = {
    setupData: {},
    setupDataForPoolList: [],
    selectedFarmList: [],
    selectedCoin: null,
    selectedPool: null,
    error: null,
    isLoading: true,
    isLoadingPool: true,
};

const getters = {
    setupData: state => state.setupData,
    setupDataForPoolList: state => state.setupDataForPoolList,
    selectedFarmList: state => state.selectedFarmList,
    selectedCoin: state => state.selectedCoin,
    selectedPool: state => state.selectedPool,
    error: state => state.error,
    isLoading: state => state.isLoading,
    isLoadingPool: state => state.isLoadingPool
};

const mutations = {
    SET_SETUP_DATA: (state, payload) => state.setupData = payload,
    SET_SETUP_DATA_FOR_POOL_LIST: (state, payload) => {
        payload.forEach((item) => {
            item.hashrate = Vue.prototype.$HashrateConvertorPlugin.convert(item.hashrate);
        });
        state.setupDataForPoolList = payload;
    },
    UPDATE_SELECTED_FARM_LIST: (state, payload) => state.selectedFarmList = payload,
    UPDATE_SELECTED_COIN: (state, payload) => state.selectedCoin = payload,
    UPDATE_SELECTED_POOL: (state, payload) => state.selectedPool = payload,
    SET_ERROR: (state, payload) => state.error = payload,
    LOADING: (state) => state.isLoading = true,
    LOADING_POOL: (state) => state.isLoadingPool = true,
    FINISHED_LOADING: (state) => state.isLoading = false,
    FINISHED_LOADING_POOL: (state) => state.isLoadingPool = false,
    resetStateData: (state) => state = Object.assign(state, initState)
};

const actions = {
    loadSetupData: ({commit}) => {
        commit('LOADING');
        return new Promise((resolve, reject) => {
            axios.get(baseUrl + 'modules/remotestart/setup')
                .then(response => {
                    commit('SET_SETUP_DATA', response.data);
                    resolve(response);
                })
                .catch(error => {
                    commit('SET_ERROR', error.message);
                    reject(error);
                })
                .finally(() => {
                    commit('FINISHED_LOADING');
                });
        });
    },
    loadPoolList: ({commit}, coin_ticker) => {
        commit('LOADING_POOL');
        return new Promise((resolve, reject) => {
            axios.get(baseUrl + 'modules/remotestart/setup/pooldata/' + coin_ticker)
                .then(response => {
                    commit('SET_SETUP_DATA_FOR_POOL_LIST', response.data);
                    resolve(response);
                })
                .catch(error => {
                    commit('SET_SETUP_DATA_FOR_POOL_LIST', []);
                    commit('SET_ERROR', error.message);
                    reject(error);
                })
                .finally(() => {
                    commit('FINISHED_LOADING_POOL');
                })
        });
    },
    updateSelectedFarmList: ({commit}, farmList) => {
        commit('UPDATE_SELECTED_FARM_LIST', farmList);
    },
    updateSelectedCoin: ({commit, dispatch}, coin) => {
        commit('UPDATE_SELECTED_COIN', coin);
        commit('UPDATE_SELECTED_POOL', null);
        return new Promise(() => {
            dispatch('loadPoolList', coin.coin_ticker)
                .catch(error => {
                });
        });
    },
    updateSelectedPool: ({commit}, pool) => {
        commit('UPDATE_SELECTED_POOL', pool);
    },
    resetStateData: ({commit}) => {
        commit('resetStateData');
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}