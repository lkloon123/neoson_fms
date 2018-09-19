<template>
    <div class="login-box">
        <div class="login-logo"><b>NeoSon</b> Crypto</div>

        <div class="login-box-body">
            <p class="login-box-msg">Please Enter your new password</p>

            <div class="form-group has-feedback" :class="{ 'has-error': errors.has('Password') }">
                <input type="password"
                       name="Password"
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
                       v-model="confirm_password"
                       class="form-control"
                       placeholder="Confirm Password"
                       v-validate="'required'"
                       @keyup.enter="register">

                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" @click="handleSubmit" class="btn btn-primary btn-block">
                        Submit
                    </button>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            validated: false,
            errorMsg: 'There\'s some error, please make sure you click the correct link.',
            password: null,
            confirm_password: null
        }),
        computed: {
            email() {
                return this.$route.query.e;
            },
            reset_password_token() {
                return this.$route.query.t;
            }
        },
        methods: {
            handleSubmit(event) {
                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        this.$SpinnerPlugin.showSpinner(event.target);
                        axios.post(baseUrl + 'auth/reset', {
                            reset_password_token: this.reset_password_token,
                            email: this.email,
                            password: this.password,
                            confirm_password: this.confirm_password
                        }).then(response => {
                            this.$router.push('/login');
                            this.$SweetAlertPlugin.basicDialog(response.data.msg);
                        }).catch(error => {
                            this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                        }).finally(() => {
                            this.$SpinnerPlugin.hideSpinner();
                        });
                    } else {
                        this.$SweetAlertPlugin.basicDialog(this.errors.all()[0], 'error');
                    }
                });
            }
        },
        mounted() {
            if (!this.validated) {
                this.$SweetAlertPlugin.basicDialog(this.errorMsg, 'error');
                this.$router.push('/login');
            }
        },
        created() {
            if (this.email !== undefined && this.email !== null && this.email !== ''
                && this.reset_password_token !== undefined && this.reset_password_token !== null && this.reset_password_token !== '') {
                this.validated = true;
                this.errorMsg = null;
            }
        }
    }
</script>

<style scoped>

</style>