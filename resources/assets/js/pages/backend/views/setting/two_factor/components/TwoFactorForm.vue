<template>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="form-group has-feedback"
                 :class="{ 'has-error': errors.has('Two Factor Authentication Code') }">
                <input ref="code"
                       name="Two Factor Authentication Code"
                       type="password"
                       class="form-control"
                       v-model="formData.code"
                       v-validate="'required|digits:6'"
                       placeholder="6-digit authentication code"
                       @keyup.enter="handleSubmit">
            </div>
            <button type="submit" @click="handleSubmit" class="btn btn-primary">
                Submit
            </button>
        </div>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';

    export default {
        props: {
            link: String,
        },
        data: () => ({
            formData: {
                code: null,
            }
        }),
        methods: {
            ...mapActions({
                checkTwoFactorStatus: 'twofactor/checkTwoFactorStatus'
            }),
            handleSubmit(event) {
                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        this.$SpinnerPlugin.showSpinner(event.target);
                        axios.post(baseUrl + this.link, {two_factor_code: this.formData.code})
                            .then(response => {
                                this.checkTwoFactorStatus();
                                this.$SweetAlertPlugin.basicDialog(response.data.msg);
                            })
                            .catch(error => {
                                this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                            })
                            .finally(() => {
                                this.$SpinnerPlugin.hideSpinner();
                            });
                    } else {
                        this.$SweetAlertPlugin.basicDialog(this.errors.all()[0], 'error');
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>