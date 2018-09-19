<template>
    <div class="box box-info box-solid collapsed-box" id="nicehash-account-collapse-add">
        <div class="box-header with-border">
            <h3 class="box-title">Add New Nicehash Account</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="box-body" style="display: none">
            <div class="form-group" :class="{ 'has-error': errors.has('Account Name') }">
                <input name="Account Name"
                       type="text"
                       class="form-control"
                       v-model="account_name"
                       v-validate="'required'"
                       placeholder="Account Name">
            </div>

            <div class="form-group" :class="{ 'has-error': errors.has('Wallet Address') }">
                <input name="Wallet Address"
                       type="text"
                       class="form-control"
                       v-model="wallet_address"
                       v-validate="'required'"
                       placeholder="Wallet Address">
            </div>
            <button type="button" class="btn btn-primary pull-right" @click="handleSubmit">Add</button>
        </div>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';

    export default {
        data: () => ({
            account_name: '',
            wallet_address: '',
            is_notification_enabled: true,
        }),
        methods: {
            ...mapActions({
                addNicehashAccount: 'nicehash/addNicehashAccount'
            }),
            handleSubmit(event) {
                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        this.$SpinnerPlugin.showSpinner(event.target);
                        this.addNicehashAccount({
                            account_name: this.account_name,
                            wallet_address: this.wallet_address,
                            is_notification_enabled: this.is_notification_enabled,
                        }).then(response => {
                            this.$awn.success(response.data.msg);
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
            $('#nicehash-account-collapse-add').boxWidget({
                collapseIcon: 'fa-minus',
                expandIcon: 'fa-plus'
            })
        }
    }
</script>

<style scoped>

</style>