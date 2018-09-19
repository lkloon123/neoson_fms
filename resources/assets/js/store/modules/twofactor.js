import axios from 'axios';

const disableModel = {
    colorClass: 'text-red',
    alertClass: 'success',
    alertIcon: 'fa-thumbs-up',
    alertMsg: 'Enabling two-factor authentication is highly recommended!',
    status: 'Disabled',
};
const enabledModel = {
    colorClass: 'text-green',
    alertClass: 'danger',
    alertIcon: 'fa-exclamation-triangle',
    alertMsg: 'Disabling two-factor authentication will put your account at risk!',
    status: 'Enabled'
};

const initState = {
    colorClass: 'text-red',
    alertClass: 'success',
    alertIcon: 'fa-thumbs-up',
    alertMsg: 'Enabling two-factor authentication is highly recommended!',
    status: null,
};

const state = {
    colorClass: 'text-red',
    alertClass: 'success',
    alertIcon: 'fa-thumbs-up',
    alertMsg: 'Enabling two-factor authentication is highly recommended!',
    status: null,
};

const mutations = {
    SET_TWO_FACTOR: (state, payload) => {
        state = Object.assign(state, payload);
    },
    resetStateData: (state) => {
        state = Object.assign(state, initState);
    }
};

const actions = {
    checkTwoFactorStatus: (context) => {
        axios.post(baseUrl + "setting/twofa/check")
            .then(response => {
                context.commit('SET_TWO_FACTOR', enabledModel);
            })
            .catch(error => {
                context.commit('SET_TWO_FACTOR', disableModel);
            });
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions
}