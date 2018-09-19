import axios from 'axios';

const initState = {
    minerList: [],
    error: null,
    isLoading: true,
};

const state = {
    minerList: [],
    error: null,
    isLoading: true,
};

const getters = {
    minerList: state => _.chunk(state.minerList, 3),
    minerListWithoutChunk: state => state.minerList,
    minerList_search: state => index => {
        return state.minerList.filter(miner => miner.belongs_to_farm.id === index)
    },
    isLoading: state => state.isLoading,
    error: state => state.error
};

const mutations = {
    SET_MINER_LIST: (state, payload) => state.minerList = payload,
    ADD_MINER: (state, payload) => state.minerList.push(payload),
    UPDATE_MINER: (state, payload) => state.minerList.map(miner => {
        if (miner.id === payload.id) {
            if (payload.farm_id) {
                miner.belongs_to_farm.id = payload.farm_id;
                Object.assign(miner, _.omit(payload, 'farm_id'));
            } else {
                Object.assign(miner, payload);
            }
        }
    }),
    DELETE_MINER: (state, payload) => state.minerList = state.minerList.filter(miner => miner !== payload),
    SET_ERROR: (state, payload) => state.error = payload,
    LOADING: (state) => state.isLoading = true,
    FINISHED_LOADING: (state) => state.isLoading = false,
    resetStateData: (state) => state = Object.assign(state, initState)
};

const actions = {
    loadMinerList: ({commit}) => {
        commit('LOADING');
        return new Promise((resolve, reject) => {
            axios.get(baseUrl + 'miner')
                .then(response => {
                    commit('SET_MINER_LIST', response.data);
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
    addMiner: ({commit}, minerData) => {
        return new Promise((resolve, reject) => {
            axios.post(baseUrl + 'miner', minerData)
                .then(response => {
                    //find the added miner
                    axios.get(baseUrl + 'miner/' + response.data.id)
                        .then(findMinerResponse => {
                            commit('ADD_MINER', findMinerResponse.data);
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
    updateMiner: ({commit, dispatch}, minerData) => {
        commit('UPDATE_MINER', minerData);
        return new Promise((resolve, reject) => {
            axios.put(baseUrl + 'miner/' + minerData.id, minerData)
                .then(response => {
                    //reload miner
                    dispatch('loadMinerList')
                        .then(reloadFarmResponse => {
                            resolve(response);
                        })
                        .catch(error => {
                            commit('SET_ERROR', error.message);
                            reject(error);
                        });
                })
                .catch(error => {
                    commit('SET_ERROR', error.message);
                    dispatch('loadMinerList')
                        .catch(error => {
                            commit('SET_ERROR', error.message);
                            reject(error);
                        });
                    reject(error);
                });
        });
    },
    deleteMiner: ({commit}, minerData) => {
        return new Promise((resolve, reject) => {
            axios.delete(baseUrl + 'miner/' + minerData.id)
                .then(response => {
                    commit('DELETE_MINER', minerData);
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