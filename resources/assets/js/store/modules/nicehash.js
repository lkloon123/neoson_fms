import axios from 'axios';

const initState = {
    nicehashAccountList: [],
    error: null,
    isLoading: true,
};

const state = {
    nicehashAccountList: [],
    error: null,
    isLoading: true,
};

const getters = {
    nicehashAccountList: state => _.chunk(state.nicehashAccountList, 3),
    error: state => state.error,
    isLoading: state => state.isLoading,
};

const mutations = {
    SET_NICEHASH_ACCOUNT_LIST: (state, payload) => state.nicehashAccountList = payload,
    ADD_NICEHASH_ACCOUNT: (state, payload) => state.nicehashAccountList.push(payload),
    UPDATE_NICEHASH_ACCOUNT: (state, payload) => state.nicehashAccountList.map(nicehashAccount => {
        if (nicehashAccount.id === payload.id) {
            Object.assign(nicehashAccount, payload);
        }
    }),
    DELETE_NICEHASH_ACCOUNT: (state, payload) => state.nicehashAccountList = state.nicehashAccountList.filter(nicehashAccount => nicehashAccount !== payload),
    SET_ERROR: (state, payload) => state.error = payload,
    LOADING: (state) => state.isLoading = true,
    FINISHED_LOADING: (state) => state.isLoading = false,
    resetStateData: (state) => state = Object.assign(state, initState)
};

const actions = {
    loadNicehashAccountList: ({commit}) => {
        commit('LOADING');
        return new Promise((resolve, reject) => {
            axios.get(baseUrl + 'nicehash/account')
                .then(response => {
                    commit('SET_NICEHASH_ACCOUNT_LIST', response.data);
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
    addNicehashAccount: ({commit}, nicehashAccountData) => {
        return new Promise((resolve, reject) => {
            axios.post(baseUrl + 'nicehash/account', nicehashAccountData)
                .then(response => {
                    //find the added nicehash
                    axios.get(baseUrl + 'nicehash/account/' + response.data.id)
                        .then(findNicehashAccountResponse => {
                            commit('ADD_NICEHASH_ACCOUNT', findNicehashAccountResponse.data);
                            resolve(response);
                        })
                        .catch((error) => {
                            commit('SET_ERROR', error.message);
                            reject(error);
                        });
                })
                .catch(error => {
                    commit('SET_ERROR', error.message);
                    reject(error);
                });
        });
    },
    updateNicehashAccount: ({commit, dispatch}, nicehashAccountData) => {
        commit('UPDATE_NICEHASH_ACCOUNT', nicehashAccountData);
        return new Promise((resolve, reject) => {
            axios.put(baseUrl + 'nicehash/account/' + nicehashAccountData.id, nicehashAccountData)
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    commit('SET_ERROR', error.message);
                    dispatch('loadNicehashAccountList')
                        .catch(error => {
                            commit('SET_ERROR', error.message);
                            reject(error);
                        });
                    reject(error);
                });
        });
    },
    deleteNicehashAccount: ({commit}, nicehashAccountData) => {
        return new Promise((resolve, reject) => {
            axios.delete(baseUrl + 'nicehash/account/' + nicehashAccountData.id)
                .then(response => {
                    commit('DELETE_NICEHASH_ACCOUNT', nicehashAccountData);
                    resolve(response);
                })
                .catch(error => {
                    commit('SET_ERROR', error.message);
                    reject(error);
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