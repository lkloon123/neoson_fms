import axios from 'axios';

const initState = {
    notificationList: [],
    error: null,
    isLoading: true,
};

const state = {
    notificationList: [],
    error: null,
    isLoading: true,
};

const getters = {
    notificationList: state => state.notificationList,
    unreadNotificationAmount: state => {
        return state.notificationList.filter(notification => {
            return !notification.is_read
        }).length;
    },
    error: state => state.error,
    isLoading: state => state.isLoading,
};

const mutations = {
    SET_NOTIFICATION_LIST: (state, payload) => state.notificationList = payload,
    UPDATE_NOTIFICATION: (state, payload) => state.notificationList.map(notification => {
        if (notification.id === payload.id) {
            Object.assign(notification, payload);
        }
    }),
    MARK_ALL_AS_READ_OR_UNREAD: (state, payload) => state.notificationList.map(notification => {
        if (notification.is_read === !payload) {
            notification.is_read = payload;
        }
    }),
    SET_ERROR: (state, payload) => state.error = payload,
    LOADING: (state) => state.isLoading = true,
    FINISHED_LOADING: (state) => state.isLoading = false,
    resetStateData: (state) => state = Object.assign(state, initState)
};

const actions = {
    loadNotificationList: ({commit, getters}) => {
        return new Promise((resolve, reject) => {
            axios.get(baseUrl + 'notification')
                .then(response => {
                    if (!_.isEqual(response.data, getters.notificationList)) {
                        commit('SET_NOTIFICATION_LIST', response.data);
                    }
                    resolve(response);
                })
                .catch(error => {
                    if (!_.isEmpty(getters.notificationList)) {
                        commit('SET_NOTIFICATION_LIST', []);
                    }
                    if (getters.error === null) {
                        commit('SET_ERROR', error.message);
                    }
                    reject(error);
                });
        });

    },
    updateNotification: ({commit, dispatch}, notificationData) => {
        commit('UPDATE_NOTIFICATION', notificationData);
        return new Promise((resolve, reject) => {
            axios.put(baseUrl + 'notification/' + notificationData.id, notificationData)
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    commit('SET_ERROR', error.message);
                    dispatch('loadNotificationList')
                        .catch(error => {
                            commit('SET_ERROR', error.message);
                            reject(error);
                        });
                    reject(error);
                });
        });
    },
    markAllAsReadOrUnread: ({commit, dispatch}, type) => {
        commit('MARK_ALL_AS_READ_OR_UNREAD', type);
        return new Promise((resolve, reject) => {
            axios.put(baseUrl + 'notification/update/all', {
                is_read: type
            }).then(response => {
                resolve(response);
            }).catch(error => {
                commit('SET_ERROR', error.message);
                dispatch('loadNotificationList')
                    .catch(error => {
                        commit('SET_ERROR', error.message);
                        reject(error);
                    });
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