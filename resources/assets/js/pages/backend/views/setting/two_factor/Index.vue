<template>
    <div>
        <section class="content-header">
            <h1>Two-Factor Authentication<br/>
                <small>Greatly increase security by requiring both your password and two factor authentication.</small>
            </h1>
        </section>

        <section class="content">
            <div class="row" v-if="twoFactor.status !== null">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-body text-center">
                            <h4>Status : <span :class="twoFactor.colorClass">{{twoFactor.status}}</span></h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" v-if="twoFactor.status !== null">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <alert :type="twoFactor.alertClass" :icon="twoFactor.alertIcon"
                           :message="twoFactor.alertMsg"></alert>
                </div>
            </div>

            <div v-if="twoFactor.status !== null">
                <two-factor-setup v-if="twoFactor.status === 'Disabled'"></two-factor-setup>
                <two-factor-disable v-else></two-factor-disable>
            </div>

        </section>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';
    import Alert from "../../../../../components/Alert";
    import TwoFactorSetup from "./components/TwoFactorSetup";
    import TwoFactorDisable from "./components/TwoFactorDisable";

    export default {
        computed: {
            twoFactor() {
                return this.$store.state.twofactor;
            }
        },
        methods: {
            ...mapActions({
                checkTwoFactorStatus: 'twofactor/checkTwoFactorStatus'
            })
        },
        components: {
            Alert, TwoFactorSetup, TwoFactorDisable
        },
        created() {
            this.checkTwoFactorStatus();
        }
    }
</script>

<style scoped>
    .content-header > h1 > small {
        padding-left: 0;
    }
</style>