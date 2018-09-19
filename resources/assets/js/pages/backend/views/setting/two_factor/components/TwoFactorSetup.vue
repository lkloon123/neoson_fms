<template>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border text-center">
                    <h4>Two-Factor Authentication Setup</h4>
                </div>
                <div class="box-body text-center">
                    <div class="qr row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <img :src="setup.qr">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-xs-3"></div>
                        <div class="col-md-8 col-xs-6">
                            <strong>{{setup.secret}}</strong>
                        </div>
                        <div class="col-md-2 col-xs-3">
                            <i id="setupRefresh" @click="getSetupData" class="fa fa-refresh fa-lg text-green"
                               :class="{'fa-spin':setup.isLoading}"></i>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-center">
                    <two-factor-form :link="'setting/twofa/setup/save'"></two-factor-form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import TwoFactorForm from "./TwoFactorForm";

    export default {
        data: () => ({
            setup: {
                isLoading: false,
                secret: null,
                qr: null,
            }
        }),
        methods: {
            getSetupData() {
                this.setup.isLoading = true;
                axios.post(baseUrl + "setting/twofa/setup")
                    .then(response => {
                        this.setup.secret = response.data.secret;
                        this.setup.qr = response.data.qr;
                        this.$refs.two_factor_code.focus();
                    })
                    .catch(error => {

                    })
                    .finally(() => {
                        setTimeout(() => {
                            this.setup.isLoading = false;
                        }, 500);
                    });
            }
        },
        components: {
            TwoFactorForm
        },
        mounted() {
            this.getSetupData();
        }
    }
</script>

<style scoped>
    #setupRefresh {
        cursor: pointer;
    }

    .qr {
        margin-top: 5px;
        margin-bottom: 15px;
    }
</style>