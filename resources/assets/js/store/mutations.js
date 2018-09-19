const updateLoader = (state, payload) => state.showLoader = payload;
const setLoginCaptchaRequired = (state, payload) => {
    if (payload === true) {
        localStorage.setItem('loginCaptchaRequired', payload.toString());
    } else {
        localStorage.removeItem('loginCaptchaRequired');
    }
    state.loginCaptchaRequired = payload;
};
const setCurrency = (state, payload) => {
    if (payload == null) {
        if (localStorage.getItem('currency')) {
            state.currency = JSON.parse(localStorage.getItem('currency'));
        }
    } else {
        localStorage.setItem('currency', JSON.stringify(payload));
        state.currency = payload;
    }
};

export {
    updateLoader,
    setLoginCaptchaRequired,
    setCurrency
}