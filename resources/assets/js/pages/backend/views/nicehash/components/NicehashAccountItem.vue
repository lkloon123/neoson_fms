<template>
    <div class="box box-primary box-solid collapsed-box" :id="collapseButtonClass">
        <div class="box-header with-border">
            <h3 class="box-title">{{ nicehashAccountData.account_name }}</h3>
            <div class="box-tools pull-right">
                <delete-nicehash-account :nicehash-account-data="initNicehashAccountData"></delete-nicehash-account>
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="box-body" style="display: none">
            <div class="form-group">
                <span>Notification : </span>
                <toggle-button v-model="nicehashAccountData.is_notification_enabled"
                               @change="handleNotificationStatusChange"
                               :title="changeNotificationStatusToolTip"
                               :disabled="isUpdating"
                               :sync="true"></toggle-button>
            </div>

            <div class="form-group">
                <span>Notify once : </span>
                <toggle-button v-model="nicehashAccountData.is_notify_once"
                               @change="handleNotifyOneChange"
                               :title="changeNotificationStatusToolTip"
                               :disabled="isUpdating"
                               :sync="true"></toggle-button>
            </div>

            <div class="form-group input-group no-margin"
                 :class="{ 'has-error': errors.has('Wallet Address') }">
                <input type="text"
                       class="form-control"
                       name="Wallet Address"
                       v-model="nicehashAccountData.wallet_address"
                       v-validate="'required'"
                       placeholder="wallet address"
                       :disabled="isUpdating"/>
                <span class="input-group-btn">
                    <button type="button"
                            class="btn btn-primary"
                            title="Click to save wallet address"
                            @click="handleUpdate"
                            :disabled="isUpdating">
                        <i class="fa fa-check-circle fa-lg"></i>
                    </button>
                </span>
            </div>
        </div>
        <loading-overlay v-if="isLoading === true"></loading-overlay>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import LoadingOverlay from '../../../../../components/LoadingOverlayForBox';
    import DeleteNicehashAccount from "./DeleteNicehashAccount";
    import ToggleButton from 'vue-js-toggle-button/src/Button';

    export default {
        props: {
            initNicehashAccountData: {
                type: Object,
                required: true
            }
        },
        data: () => ({
            isUpdating: false
        }),
        computed: {
            ...mapGetters({
                isLoading: 'nicehash/isLoading',
            }),
            nicehashAccountData() {
                return Object.assign({}, this.initNicehashAccountData);
            },
            collapseButtonClass() {
                return 'nicehash-account-collapse-' + this.nicehashAccountData.id;
            },
            changeNotificationStatusToolTip() {
                return 'Click to ' + (this.nicehashAccountData.is_notification_enabled ? 'disable' : 'enable') + ' notification';
            },
            changeNotifyOnceToolTip() {
                return 'Click to ' + (this.nicehashAccountData.is_notify_once ? 'disable' : 'enable') + ' notify once';
            },
        },
        methods: {
            ...mapActions({
                updateNicehashAccount: 'nicehash/updateNicehashAccount'
            }),
            handleNotificationStatusChange(event) {
                this.isUpdating = true;
                this.updateNicehashAccount({
                    id: this.nicehashAccountData.id,
                    is_notification_enabled: this.nicehashAccountData.is_notification_enabled
                }).catch(error => {
                    this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                }).finally(() => {
                    this.isUpdating = false;
                });
            },
            handleNotifyOneChange(event){
                this.isUpdating = true;
                this.updateNicehashAccount({
                    id: this.nicehashAccountData.id,
                    is_notify_once: this.nicehashAccountData.is_notify_once
                }).catch(error => {
                    this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                }).finally(() => {
                    this.isUpdating = false;
                });
            },
            handleUpdate(event) {
                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        this.$SpinnerPlugin.showSpinner(event.currentTarget);
                        this.isUpdating = true;
                        this.updateNicehashAccount({
                            id: this.nicehashAccountData.id,
                            wallet_address: this.nicehashAccountData.wallet_address
                        }).then(response => {
                            this.$awn.success(response.data.msg);
                        }).catch(error => {
                            this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                        }).finally(() => {
                            this.isUpdating = false;
                            this.$SpinnerPlugin.hideSpinner(null, '<i class="fa fa-check-circle fa-lg"></i>');
                        });
                    } else {
                        this.$SweetAlertPlugin.basicDialog(this.errors.all()[0], 'error');
                    }
                });
            }
        },
        components: {
            DeleteNicehashAccount, LoadingOverlay, ToggleButton
        },
        mounted() {
            $('#' + this.collapseButtonClass).boxWidget({
                collapseIcon: 'fa-minus',
                expandIcon: 'fa-plus'
            })
        }
    }
</script>

<style scoped>

</style>