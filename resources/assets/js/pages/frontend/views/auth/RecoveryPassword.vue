<template>
    <div class="login-box">
        <div class="login-logo"><b>NeoSon</b> Crypto</div>

        <div class="login-box-body">
            <p class="login-box-msg">Reset Password</p>

            <div class="form-group has-feedback" :class="{ 'has-error': errors.has('Email') }">
                <input type="email"
                       name="Email"
                       v-model="email"
                       class="form-control"
                       placeholder="Email"
                       v-validate="'required|email'"
                       @keyup.enter="handleSubmit">

                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>

            <div class="row">
                <div class="col-md-7 col-xs-7">
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <router-link class="text-sm" to="/login">Go To Login</router-link>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <router-link class="text-sm" to="/register">Don't Have Account?</router-link>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-xs-5">
                    <button type="submit" class="btn btn-primary btn-block btn-login" @click="handleSubmit">
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
            email: null
        }),
        methods: {
            handleSubmit(event) {
                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        axios.post(baseUrl + 'auth/recovery', {
                            email: this.email
                        }).then(response => {
                            this.email = null;
                            this.$SweetAlertPlugin.basicDialog(response.data.msg);
                        }).catch(error => {
                            this.$SweetAlertPlugin.basicDialog(error.message, 'error');
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