import axios from 'axios';

const initState = {
    farmList: [],
    userFarmPermissionList: [],
    farmPermissionTextList: [],
    error: null,
    isLoading: true,
};

const state = {
    farmList: [],
    userFarmPermissionList: [],
    farmPermissionTextList: [],
    error: null,
    isLoading: true,
};

const getters = {
    farmList: state => _.chunk(state.farmList, 3),
    farmListWithoutChunk: state => state.farmList,
    getUserFarmPermissionListById: state => id => state.userFarmPermissionList.filter(farm => farm.id === id)[0],
    canUserModifyPermission: (state, getters) => id => {
        return !_.isEmpty(getters.getUserFarmPermissionListById(id)) &&
            getters.getUserFarmPermissionListById(id).permission.permission;
    },
    doUserHaveUpdatePermission: (state, getters) => id => {
        return !_.isEmpty(getters.getUserFarmPermissionListById(id)) &&
            getters.getUserFarmPermissionListById(id).permission.update;
    },
    doUserHaveDeletePermission: (state, getters) => id => {
        return !_.isEmpty(getters.getUserFarmPermissionListById(id)) &&
            getters.getUserFarmPermissionListById(id).permission.delete;
    },
    getFarmPermissionTextList: state => state.farmPermissionTextList,
    error: state => state.error,
    isLoading: state => state.isLoading,
};

const mutations = {
    SET_FARM_LIST: (state, payload) => state.farmList = payload,
    ADD_FARM: (state, payload) => state.farmList.push(payload),
    UPDATE_FARM: (state, payload) => state.farmList.map(farm => {
        if (farm.id === payload.id) {
            Object.assign(farm, payload);
        }
    }),
    DELETE_FARM: (state, payload) => state.farmList = state.farmList.filter(farm => farm !== payload),
    SET_ERROR: (state, payload) => state.error = payload,
    LOADING: (state) => state.isLoading = true,
    FINISHED_LOADING: (state) => state.isLoading = false,
    SET_USER_FARM_PERMISSION_LIST: (state, payload) => state.userFarmPermissionList = payload,
    SET_FARM_PERMISSION_LIST: (state, payload) => state.farmPermissionTextList = payload,
    resetStateData: (state) => state = Object.assign(state, initState)
};

const actions = {
    loadFarmList: ({commit}) => {
        commit('LOADING');
        return new Promise((resolve, reject) => {
            axios.get(baseUrl + 'farm')
                .then(response => {
                    commit('SET_FARM_LIST', response.data);
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
    addFarm: ({commit, dispatch}, farmData) => {
        return new Promise((resolve, reject) => {
            axios.post(baseUrl + 'farm', farmData)
                .then(response => {
                    //find the added farm
                    axios.get(baseUrl + 'farm/' + response.data.id)
                        .then(findFarmResponse => {
                            commit('ADD_FARM', findFarmResponse.data);
                            resolve(response);
                        })
                        .catch((error) => {
                            commit('SET_ERROR', error.message);
                            reject(error);
                        });
                    //load permission
                    dispatch('loadUserFarmPermissionList')
                        .catch(error => {
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
    updateFarm: ({commit, dispatch}, farmData) => {
        commit('UPDATE_FARM', farmData);
        return new Promise((resolve, reject) => {
            axios.put(baseUrl + 'farm/' + farmData.id, farmData)
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    commit('SET_ERROR', error.message);
                    dispatch('loadFarmList')
                        .catch(error => {
                            commit('SET_ERROR', error.message);
                            reject(error);
                        });
                    reject(error);
                });
        });
    },
    deleteFarm: ({commit}, farmData) => {
        return new Promise((resolve, reject) => {
            axios.delete(baseUrl + 'farm/' + farmData.id)
                .then(response => {
                    commit('DELETE_FARM', farmData);
                    resolve(response);
                })
                .catch(error => {
                    commit('SET_ERROR', error.message);
                    reject(error);
                });
        });
    },

    loadUserFarmPermissionList: ({commit}) => {
        return new Promise((resolve, reject) => {
            axios.get(baseUrl + 'farm/permission')
                .then(response => {
                    commit('SET_USER_FARM_PERMISSION_LIST', response.data);
                    resolve(response);
                })
                .catch(error => {
                    commit('SET_ERROR', error.message);
                    reject(error);
                });
        });
    },
    loadFarmPermissionTextList: ({commit}) => {
        return new Promise((resolve, reject) => {
            axios.get(baseUrl + 'farm/permission/list')
                .then(response => {
                    commit('SET_FARM_PERMISSION_LIST', response.data);
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