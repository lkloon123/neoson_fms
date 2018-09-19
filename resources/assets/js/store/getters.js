const showLoader = (state) => state.showLoader;
const getLoginCaptchaRequired = (state) => {
    if (state.loginCaptchaRequired == null) {
        if (localStorage.getItem('loginCaptchaRequired') != null) {
            return localStorage.getItem('loginCaptchaRequired') === 'true';
        }
        return false;
    } else {
        return state.loginCaptchaRequired;
    }
};

export {
    showLoader,
    getLoginCaptchaRequired
}