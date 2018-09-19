<template>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Create a new support ticket</h3>
        </div>
        <div class="box-body">
            <div class="form-group has-feedback"
                 :class="{ 'has-error': errors.has('Subject') }">
                <label class="control-label" for="subject">Subject</label>
                <input ref="subject"
                       id="subject"
                       name="Subject"
                       type="text"
                       class="form-control"
                       v-model="subject"
                       v-validate="'required'">
            </div>

            <div class="form-group has-feedback"
                 :class="{ 'has-error': errors.has('Message') }">
                <label class="control-label" for="message">Message</label>
                <textarea ref="message"
                          id="message"
                          name="Message"
                          class="form-control"
                          rows="5"
                          v-model="message"
                          v-validate="'required'">
                                </textarea>
            </div>

            <vue-recaptcha class="google_recapture"
                           align="center"
                           ref="recaptcha"
                           @verify="onVerify"
                           @expired="onExpired"
                           :sitekey="googleCaptchaSiteKey">
            </vue-recaptcha>
        </div>
        <div class="box-footer text-center">
            <button type="submit" @click="handleSubmit($event)" class="btn btn-primary">
                Submit
            </button>
        </div>
    </div>
</template>

<script>
    import VueRecaptcha from 'vue-recaptcha';
    import {baseUrl, googleCaptchaSiteKey} from "../../../../../env";

    export default {
        data: () => ({
            subject: null,
            message: null,
            googleCaptchaSiteKey: googleCaptchaSiteKey,
            googleCaptchaResponse: null,
        }),
        methods: {
            handleSubmit(event) {
                event.target.blur();//clear focus
                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        if (this.googleCaptchaResponse == null) {
                            this.$SweetAlertPlugin.basicDialog('Please Verify That You Are Not A Robot', 'error');
                        } else {
                            this.$SpinnerPlugin.showSpinner(event.target);
                            axios.post(baseUrl + 'support/ticket', {
                                subject: this.subject,
                                message: this.message,
                                google_captcha_response: this.googleCaptchaResponse
                            }).then(response => {
                                this.$router.push('/portal/support/ticket');
                                this.$SweetAlertPlugin.basicDialog(response.data.msg);
                            }).catch(error => {
                                this.$SweetAlertPlugin.basicDialog(error.message, 'error');
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
            this.$loadScript("https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit");
        }
    }
</script>

<style scoped>
    textarea {
        resize: none;
    }
</style>