<template>
    <div class="login-box">
        <div class="login-logo"><b>NeoSon</b> Crypto</div>

        <div class="login-box-body">
            <p class="login-box-msg">Log in to start your session</p>

            <div class="form-group has-feedback" :class="{ 'has-error': errors.has('Email') }">
                <input type="email"
                       name="Email"
                       ref="email"
                       v-model="email"
                       class="form-control"
                       placeholder="Email"
                       v-validate="'required|email'"
                       @keyup.enter="login">

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
                       @keyup.enter="login">

                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            <div v-if="isLoginCaptchaRequired" class="form-group">
                <vue-recaptcha class="google_recapture"
                               align="center"
                               ref="recaptcha"
                               @verify="onVerify"
                               @expired="onExpired"
                               :sitekey="googleCaptchaSiteKey">
                </vue-recaptcha>
            </div>

            <div class="row">
                <div class="col-md-7 col-xs-7">
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <router-link class="text-sm" to="/password/recovery">Forgot Password?</router-link>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <router-link class="text-sm" to="/register">Don't Have Account?</router-link>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-xs-5">
                    <button type="submit" @click="login" class="btn btn-primary btn-block btn-login">
                        Login
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
            email: null,
            password: null,
            googleCaptchaSiteKey: googleCaptchaSiteKey,
            googleCaptchaResponse: null,
        }),
        computed: {
            isLoginCaptchaRequired() {
                return this.$store.getters.getLoginCaptchaRequired;
            }
        },
        methods: {
            login(event) {
                event.target.blur();//clear focus
                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        if (this.isLoginCaptchaRequired && this.googleCaptchaResponse == null) {
                            this.$SweetAlertPlugin.basicDialog('Please Verify That You Are Not A Robot', 'error');
                        } else {
                            this.$SpinnerPlugin.showSpinner(event.target);
                            this.$AuthPlugin.login(this.email, this.password, this.googleCaptchaResponse)
                                .then(() => {
                                    this.$store.commit('setLoginCaptchaRequired', false);
                                    if (this.$route.query.rtn) {
                                        this.$router.push(this.$route.query.rtn);
                                    } else {
                                        this.$router.push('/portal');
                                    }
                                })
                                .catch(error => {
                                    this.resetCaptcha();
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
            resetCaptcha() {
                if (this.$refs.recaptcha) {
                    this.$refs.recaptcha.reset();
                }
            }
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

<style lang="scss" scoped>
    .login-box-body {
        position: relative;
        z-index: 1;
    }

    .btn-login {
        margin-top: 3px;
    }
</style>