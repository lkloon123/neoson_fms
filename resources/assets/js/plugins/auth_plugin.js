import axios from 'axios';
import store from "../store";

export default function (Vue) {
    Vue.auth = {
        /**
         * Login user
         *
         * @param {string} email
         * @param {string} password
         * @param {?string} googleCaptchaResponse
         */
        login(email, password, googleCaptchaResponse = null) {
            let vm = this;

            let params = {
                email: email,
                password: password,
            };

            if (googleCaptchaResponse != null) {
                params.google_captcha_response = googleCaptchaResponse;
            }

            return new Promise((resolve, reject) => {
                axios.post(baseUrl + 'auth/login', params)
                    .then(response => {
                        if (response.data.token !== undefined) {
                            vm.setToken(
                                response.data.token,
                                response.data.duration
                            );
                        }

                        resolve(response);
                    })
                    .catch(error => {
                        if (error.headers.recaptcha ||
                            error.message === _.startCase(_.toLower('invalid captcha, please try again.'))) {
                            store.commit('setLoginCaptchaRequired', true);
                        }
                        reject(error);
                    });
            });
        },

        /**
         * Register user
         *
         * @param {string} name
         * @param {string} email
         * @param {string} password
         * @param {string} confirm_password
         * @param {string} googleCaptchaResponse
         */
        register(name, email, password, confirm_password, googleCaptchaResponse) {
            let vm = this;

            let params = {
                name: name,
                email: email,
                password: password,
                confirm_password: confirm_password,
                google_captcha_response: googleCaptchaResponse
            };

            return new Promise((resolve, reject) => {
                axios.post(baseUrl + 'auth/register', params)
                    .then(response => {
                        if (response.data.token !== undefined) {
                            vm.setToken(
                                response.data.token,
                                response.data.duration
                            );
                        }

                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    });
            })
        },

        /**
         * Logout user by destroying token
         */
        logout() {
            axios.post(baseUrl + 'auth/logout');
            this.destroy();
        },

        /**
         * Check if user is authenticated
         */
        async check() {
            let token = await this.getToken();

            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;

            return !!token;
        },

        /**
         * Refresh token
         */
        refreshToken() {
            let vm = this;

            let params = {
                token: localStorage.getItem('token'),
            };

            return new Promise((resolve, reject) => {
                axios.post(baseUrl + 'auth/refresh', params)
                    .then(response => {
                        if (response.data.token !== undefined) {
                            vm.setToken(
                                response.data.token,
                                response.data.duration
                            );
                        }

                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        /**
         * Set new access and refresh token
         *
         * @param {string} token
         * @param {integer} duration
         */
        setToken(token, duration) {
            let expiration_miliseconds = parseInt(duration) * 1000;

            localStorage.setItem('token', token);
            localStorage.setItem('expiration', Date.now() + expiration_miliseconds);

            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        },

        /**
         * Get access token or if it has expired
         * get a new one using refresh token
         */
        async getToken() {
            let token = localStorage.getItem('token');
            let expiration = localStorage.getItem('expiration');

            if (!token || !expiration) {
                return null;
            }

            if (Date.now() < parseInt(expiration)) {
                return token;
            }

            await this.refreshToken()
                .then(response => {
                    token = response.data.token;
                })
                .catch(() => {
                    this.destroy();
                    token = null;
                });

            return token;
        },

        /**
         * Clear tokens from local storage
         */
        destroy() {
            localStorage.removeItem('token');
            localStorage.removeItem('expiration');
            localStorage.removeItem('user_data');
        },
    };

    Object.defineProperties(Vue.prototype, {
        $AuthPlugin: {
            get() {
                return Vue.auth;
            }
        }
    });
}