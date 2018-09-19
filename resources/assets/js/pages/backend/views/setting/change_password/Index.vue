<template>
    <div>
        <section class="content-header">
            <h1>Password</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="box">
                        <div class="box-header with-border text-center">
                            <h3 class="box-title">Edit Password</h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group has-feedback"
                                 :class="{ 'has-error': errors.has('Old Password') }">
                                <input type="password"
                                       name="Old Password"
                                       v-model="oldPassword"
                                       class="form-control"
                                       placeholder="Old Password"
                                       v-validate="'required'">

                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>

                            <div class="form-group has-feedback"
                                 :class="{ 'has-error': errors.has('New Password') }">
                                <input type="password"
                                       name="New Password"
                                       v-model="newPassword"
                                       class="form-control"
                                       placeholder="New Password"
                                       v-validate="'required'">

                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>

                            <div class="form-group has-feedback"
                                 :class="{ 'has-error': errors.has('Confirm New Password'), 'last-field': !isTwoFactorEnabled}">
                                <input type="password"
                                       name="Confirm New Password"
                                       v-model="confirmNewPassword"
                                       class="form-control"
                                       placeholder="Confirm New Password"
                                       v-validate="'required'">

                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>

                            <div class="form-group has-feedback last-field"
                                 :class="{ 'has-error': errors.has('Two Factor Authentication Code') }"
                                 v-if="isTwoFactorEnabled">
                                <input type="password"
                                       name="Two Factor Authentication Code"
                                       v-model="code"
                                       class="form-control"
                                       placeholder="Two Factor Authentication Code"
                                       v-validate="'required|digits:6'">

                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="button" class="btn btn-primary btn-block" @click="handleSave">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';

    export default {
        data: () => ({
            oldPassword: null,
            newPassword: null,
            confirmNewPassword: null,
            code: null
        }),
        computed: {
            isTwoFactorEnabled() {
                let twoFa = this.$store.state.twofactor;
                return twoFa.status !== null && twoFa.status !== 'Disabled';
            }
        },
        methods: {
            ...mapActions({
                checkTwoFactorStatus: 'twofactor/checkTwoFactorStatus',
                logout: 'resetState'
            }),
            handleSave(event) {
                let submitData = {
                    old_password: this.oldPassword,
                    new_password: this.newPassword,
                    confirm_new_password: this.confirmNewPassword
                };

                if (this.isTwoFactorEnabled === true) {
                    submitData.two_factor_code = this.code;
                }

                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        this.$SpinnerPlugin.showSpinner(event.target);
                        axios.post(baseUrl + 'auth/password/change', submitData)
                            .then(response => {
                                this.$AuthPlugin.destroy();
                                this.logout();
                                this.$router.push('/login');
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
        },
        created() {
            this.checkTwoFactorStatus();
        }
    }
</script>

<style scoped>
    .last-field {
        margin-bottom: 0;
    }
</style>