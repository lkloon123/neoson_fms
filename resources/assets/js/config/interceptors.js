import Vue from 'vue';
import axios from 'axios';
import _ from 'lodash';
import router from "../routes";

axios.interceptors.request.use(
    (config) => {
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

axios.interceptors.response.use(
    (response) => {
        let responseData = response.data;
        if (responseData.data.msg !== undefined && responseData.data.msg != null) {
            //capitalize all response msg
            responseData.data.msg = _.startCase(_.toLower(responseData.data.msg));
        }
        return responseData;
    },
    (error) => {
        switch (error.response.status) {
            case 401:
                if (error.response.data.error.message.toUpperCase() === 'TOKEN HAS EXPIRED') {
                    if (!Vue.prototype.$AuthPlugin.check()) {
                        router.push('/login');
                    }
                }
                break;
            case 422:
                let errors = _.values(error.response.data.error.errors);
                return Promise.reject({
                    status_code: error.response.status,
                    message: _.startCase(_.toLower(_.first(errors)[0])),
                    headers: error.response.headers
                });
        }

        //capitalize all error msg
        let errorData = error.response.data.error;
        errorData.message = _.startCase(_.toLower(errorData.message));
        errorData.headers = error.response.headers;
        return Promise.reject(errorData);
    }
);