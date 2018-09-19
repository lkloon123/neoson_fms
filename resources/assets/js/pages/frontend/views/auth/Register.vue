<template>
    <div class="register-box">
        <div class="register-logo"><b>NeoSon</b> Crypto</div>

        <div class="register-box-body">
            <p class="login-box-msg">Register as a new user</p>

            <div class="form-group has-feedback" :class="{ 'has-error': errors.has('Full Name') }">
                <input type="text"
                       name="Full Name"
                       ref="full_name"
                       v-model="name"
                       class="form-control"
                       placeholder="Full Name"
                       v-validate="'required'"
                       @keyup.enter="register">

                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback" :class="{ 'has-error': errors.has('Email') }">
                <input type="email"
                       name="Email"
                       ref="email"
                       v-model="email"
                       class="form-control"
                       placeholder="Email"
                       v-validate="'required|email'"
                       @keyup.enter="register">

                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback" :class="{ 'has-error': errors.has('Password') }">
                <input type="password"
                       name="Password"
                       ref="password"
                       v-model="password"
                       class="form-control"
                       placeholder="Password"
                       v-validate="'required'"
                       @keyup.enter="register">

                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback" :class="{ 'has-error': errors.has('Confirm Password') }">
                <input type="password"
                       name="Confirm Password"
                       ref="confirm_password"
                       v-model="confirm_password"
                       class="form-control"
                       placeholder="Confirm Password"
                       v-validate="'required'"
                       @keyup.enter="register">

                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>

            <div class="form-group">
                <vue-recaptcha class="google_recapture"
                               align="center"
                               ref="recaptcha"
                               @verify="onVerify"
                               @expired="onExpired"
                               :sitekey="googleCaptchaSiteKey">
                </vue-recaptcha>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" @click="register" class="btn btn-primary btn-block">
                        Register
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueRecaptcha from 'vue-recaptcha';
    import {googleCaptchaSiteKey} from "../../../../env";

    export default {
        data: () => ({
            name: null,
            email: null,
            password: null,
            confirm_password: null,
            googleCaptchaSiteKey: googleCaptchaSiteKey,
            googleCaptchaResponse: null,
        }),
        methods: {
            register(event) {
                event.target.blur();//clear focus
                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        if (this.googleCaptchaResponse == null) {
                            this.$SweetAlertPlugin.basicDialog('Please Verify That You Are Not A Robot', 'error');
                        } else {
                            this.$SpinnerPlugin.showSpinner(event.target);
                            this.$AuthPlugin.register(this.name, this.email, this.password, this.confirm_password, this.googleCaptchaResponse)
                                .then(response => {
                                    this.$router.push('/login');
                                    this.$SweetAlertPlugin.basicDialog(response.data.msg);
                                })
                                .catch(error => {
                                    this.googleCaptchaResponse = null;
                                    this.$refs.recaptcha.reset();
                                    this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                                })
                                .finally(() => {
                                    this.$SpinnerPlugin.hideSpinner();
                                });
                        }
                    } else {
                        this.$SweetAlertPlugin.basicDialog(this.errors.all()[0], 'error');
                    }
                });
            },
            onVerify(response) {
                this.googleCaptchaResponse = response;
            },
            onExpired() {
                this.googleCaptchaResponse = null;
            },
        },
        components: {
            VueRecaptcha
        },
        mounted() {
            this.$loadScript("https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit")
                .catch(error => {
                });
        }
    }
</script>

<style scoped>
    @media screen and (max-width: 575px) {
        .google_recapture {
            transform: scale(0.9);
            -webkit-transform: scale(0.9);
            transform-origin: 0 0;
            -webkit-transform-origin: 0 0;
        }
    }
</style>