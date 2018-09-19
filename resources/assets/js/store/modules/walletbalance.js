import axios from 'axios';

const initState = {
    walletBalanceList: [],
    error: null,
    isLoading: true,
};

const state = {
    walletBalanceList: [],
    error: null,
    isLoading: true,
};

const getters = {
    walletBalanceList: state => state.walletBalanceList,
    getWalletBalanceByFarm: state => searchFarmId => {
        return state.walletBalanceList.filter(walletBalance => walletBalance.farm.id === searchFarmId);
    },
    getWalletBalanceByFarmRemovedZero: state => searchFarmId => {
        return state.walletBalanceList.filter(walletBalance =>
            walletBalance.farm.id === searchFarmId && walletBalance.farm_balance > 0);
    },
    error: state => state.error,
    isLoading: state => state.isLoading,
};

const mutations = {
    SET_WALLET_BALANCE_LIST: (state, payload) => state.walletBalanceList = payload,
    SET_ERROR: (state, payload) => state.error = payload,
    LOADING: (state) => state.isLoading = true,
    FINISHED_LOADING: (state) => state.isLoading = false,
    resetStateData: (state) => state = Object.assign(state, initState)
};

const actions = {
    loadWalletBalanceList: ({commit}) => {
        commit('LOADING');
        return new Promise((resolve, reject) => {
            axios.get(baseUrl + 'wallet')
                .then(response => {
                    commit('SET_WALLET_BALANCE_LIST', response.data);
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