import axios from 'axios';

const initState = {
    data: {},
    isLoading: true,
};

const state = {
    data: {},
    isLoading: true,
};

const getters = {
    auth_user: state => {
        if (!_.isEmpty(state.data)) {
            return state.data;
        } else {
            if (localStorage.getItem('user_data')) {
                return JSON.parse(localStorage.getItem('user_data'));
            }
        }
        return {};
    },
    isAdmin: (state, getters) => {
        if (getters.auth_user && getters.auth_user.role) {
            if (getters.auth_user.role === 'superuser' || getters.auth_user.role === 'admin') {
                return true;
            }
        }
        return false;
    },
    isSuperUser: (state, getters) => {
        if (getters.auth_user && getters.auth_user.role) {
            if (getters.auth_user.role === 'superuser') {
                return true;
            }
        }
        return false;
    },
    isLoading: state => state.isLoading,
};

const mutations = {
    SET_USER: (state, payload) => {
        payload.profile_img = payload.profile_img ? payload.profile_img : '/images/default-profile.png';
        state.data = payload;
        localStorage.setItem('user_data', JSON.stringify(payload));
    },
    UPDATE_USER: (state, payload) => state.data = Object.assign(state.data, payload),
    LOADING: (state) => state.isLoading = true,
    FINISHED_LOADING: (state) => state.isLoading = false,
    resetStateData: (state) => state = Object.assign(state, initState)
};

const actions = {
    getUserData: ({commit}) => {
        commit('LOADING');
        axios.post(baseUrl + 'auth/me')
            .then(response => {
                commit('SET_USER', response.data);
            })
            .catch(error => {

            })
            .finally(() => {
                commit('FINISHED_LOADING');
            });
    },
    updateUser: ({commit, dispatch}, userData) => {
        commit('UPDATE_USER', userData);
        return new Promise((resolve, reject) => {
            axios.post(baseUrl + 'user', userData)
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    commit('SET_ERROR', error.message);
                    dispatch('getUserData')
                        .catch(error => {
                            commit('SET_ERROR', error.message);
                            reject(error);
                        });
                    reject(error);
                });
        });
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}