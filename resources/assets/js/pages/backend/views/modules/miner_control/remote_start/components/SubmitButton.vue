<template>
    <button type="button" class="btn btn-primary" @click="submitForm" :disabled="isSubmitting">
        Submit
    </button>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';

    export default {
        props: {
            twoFactorCode: {
                type: String,
                required: true,
                twoWay: true
            }
        },
        data: () => ({
            isSubmitting: false
        }),
        computed: {
            ...mapGetters({
                loadSetupError: 'remotestart/error',
                selectedFarmList: 'remotestart/selectedFarmList',
                selectedCoin: 'remotestart/selectedCoin',
                selectedPool: 'remotestart/selectedPool'
            })
        },
        methods: {
            ...mapActions({
                loadSetupData: 'remotestart/loadSetupData',
                resetRemoteStartState: 'remotestart/resetStateData',
            }),
            submitForm(event) {
                if (_.isEmpty(this.twoFactorCode)) {
                    this.$SweetAlertPlugin.basicDialog('The Two Factor Authentication Code field is required.', 'error');
                } else {
                    this.$SpinnerPlugin.showSpinner(event.target);
                    this.isSubmitting = true;
                    let processedSelectedFarm = Object.assign([], this.selectedFarmList.map(farm => farm.id));
                    axios.post(baseUrl + 'modules/remotestart/start',
                        {
                            farm_id: processedSelectedFarm,
                            coin_ticker: this.selectedCoin.coin_ticker,
                            pool_id: this.selectedPool.id,
                            twofa_code: this.twoFactorCode
                        })
                        .then(response => {
                            this.resetRemoteStartState();
                            this.$SweetAlertPlugin.basicDialog(response.data.msg, 'success', () => {
                                this.loadSetupData().catch(() => {
                                    this.$SweetAlertPlugin.basicDialog(this.loadSetupError, 'error');
                                });
                            });
                        })
                        .catch(error => {
                            this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                        })
                        .finally(() => {
                            this.isSubmitting = false;
                            this.$SpinnerPlugin.hideSpinner();
                        });
                }
            }
        }
    }
</script>

<style scoped>

</style>