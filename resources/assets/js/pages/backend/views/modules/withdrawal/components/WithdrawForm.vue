<template>
    <div class="box box-solid box-primary no-margin">
        <div class="box-header">
            <h3 class="box-title">Withdrawal</h3>
        </div>
        <div class="box-body">

            <ul class="list-unstyled">
                <li v-for="item in minerData" :key="item.id" v-if="item.miner_balance > 0">
                    <div class="checkbox">
                        <label>
                            <input class="form-check-input" type="checkbox" v-model="item.selected"
                                   @change="updateAmount">
                            {{ item.miner_name }}
                        </label>
                        <span class="pull-right balance balance-display-fix">{{ item.miner_balance }}</span>
                    </div>
                </li>
            </ul>

            <div class="form-group has-feedback pull-right"
                 :class="{ 'has-error': errors.has('Withdrawal Amount') }">
                <label for="withdrawAmountField" class="pull-left withdraw-label">Amount : </label>
                <input id="withdrawAmountField"
                       type="text"
                       name="Withdrawal Amount"
                       v-model="withdrawalAmount"
                       class="form-control withdraw-field balance"
                       v-validate="'required|decimal:8'">
            </div>

            <div class="form-group pull-right">
                <label for="feeField" class="pull-left withdraw-label">Fee : </label>
                <input id="feeField"
                       type="text"
                       v-model="fee"
                       class="form-control withdraw-field balance"
                       disabled="disabled">
            </div>

            <div class="form-group pull-right">
                <label for="nettAmount" class="pull-left withdraw-label">Net Amount : </label>
                <input id="nettAmount"
                       type="text"
                       v-model="nettAmount"
                       class="form-control withdraw-field balance"
                       disabled="disabled">
            </div>

            <div class="form-group has-feedback pull-right"
                 :class="{ 'has-error': errors.has('Withdrawal Address') }">
                <label for="withdrawAddress" class="pull-left withdraw-label">Address : </label>
                <input id="withdrawAddress"
                       type="text"
                       name="Withdrawal Address"
                       v-model="withdrawAddress"
                       class="form-control withdraw-field"
                       v-validate="'required'">
            </div>

            <div class="form-group has-feedback pull-right no-margin"
                 :class="{ 'has-error': errors.has('Two Factor Authentication Code') }">
                <label for="twoFACode" class="pull-left withdraw-label">2FA Code : </label>
                <input id="twoFACode"
                       type="password"
                       name="Two Factor Authentication Cod"
                       v-model="two_factor_code"
                       class="form-control withdraw-field"
                       v-validate="'required|digits:6'">
            </div>
        </div>

        <div class="box-footer text-right">
            <button type="submit" class="btn btn-info" @click="getFee" title="Click To Calculate Fee"
                    :disabled="isLoadingFee || isProcessingWithdraw">
                <i class="fa fa-calculator"></i>
            </button>
            <button type="submit" class="btn btn-primary"
                    v-if="shouldShowSubmitButton"
                    @click="handleSubmit"
                    title="Click To Withdraw"
                    :disabled="isProcessingWithdraw">
                <i class="fa fa-upload"></i>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            initMinerData: {
                type: Array,
                required: true
            },
            selectedCoin: {
                type: Object,
                required: true
            },
            initFarmData: {
                type: Object,
                required: true
            }
        },
        data: () => ({
            minerData: [],
            withdrawalAmount: 0,
            nettAmount: 0,
            withdrawAddress: '',
            two_factor_code: '',
            fee: 0,
            isLoadingFee: false,
            isCalculateButtonClicked: false,
            isProcessingWithdraw: false
        }),
        computed: {
            selectedMiner() {
                return this.minerData
                    .filter(miner => miner.selected === true)
                    .map(miner => miner.id);
            },
            shouldShowSubmitButton() {
                return this.isCalculateButtonClicked === true &&
                    this.fee !== 'Calculating...' &&
                    this.fee !== 'error' &&
                    !_.isEmpty(this.fee);
            }
        },
        watch: {
            withdrawalAmount() {
                this.isCalculateButtonClicked = false;
            },
            isLoadingFee(newValue) {
                if (newValue === true) {
                    this.fee = 'Calculating...';
                    this.nettAmount = 'Calculating...';
                }
            }
        },
        methods: {
            updateAmount() {
                this.withdrawalAmount = 0;
                let vm = this;
                this.minerData.forEach(data => {
                    if (data.selected === true) {
                        vm.withdrawalAmount += data.miner_balance;
                    }
                });
                this.withdrawalAmount = this.withdrawalAmount.toFixed(8);
            },
            getFee(event) {
                this.$SpinnerPlugin.showSpinner(event.currentTarget);
                this.isCalculateButtonClicked = true;
                this.isLoadingFee = true;
                axios.post(baseUrl + 'modules/withdrawal/fee', {
                    coin_id: this.selectedCoin.id,
                    withdraw_amount: this.withdrawalAmount,
                    miner_ids: this.selectedMiner,
                    farm_id: this.initFarmData.id
                }).then(response => {
                    this.fee = response.data.fee;
                    this.nettAmount = response.data.nettAmount;
                }).catch(error => {
                    this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                    this.fee = 'error';
                    this.nettAmount = 'error';
                }).finally(() => {
                    this.isLoadingFee = false;
                    this.$SpinnerPlugin.hideSpinner(null, '<i class="fa fa-calculator"></i>');
                });
            },
            handleSubmit(event) {
                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        this.$SpinnerPlugin.showSpinner(event.currentTarget);
                        this.isProcessingWithdraw = true;
                        axios.post(baseUrl + 'modules/withdrawal/request', {
                            coin_id: this.selectedCoin.id,
                            withdraw_amount: this.withdrawalAmount,
                            miner_ids: this.selectedMiner,
                            farm_id: this.initFarmData.id,
                            withdraw_address: this.withdrawAddress,
                            twofa_code: this.two_factor_code
                        }).then(response => {
                            this.$SweetAlertPlugin.basicDialog(response.data.msg, 'success',
                                () => {
                                    this.$router.push('/portal/module/withdrawal/history');
                                });
                        }).catch(error => {
                            this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                        }).finally(() => {
                            this.isProcessingWithdraw = false;
                            this.$SpinnerPlugin.hideSpinner(null, '<i class="fa fa-upload"></i>');
                        });
                    } else {
                        this.$SweetAlertPlugin.basicDialog(this.errors.all()[0], 'error');
                    }
                });
            }
        },
        created() {
            this.minerData = _.cloneDeep(this.initMinerData);
            this.minerData.map(data => {
                if (data.miner_balance > 0) {
                    data.selected = true
                }
            });
            this.updateAmount();
        }
    }
</script>

<style scoped>
    .checkbox {
        margin-top: 0;
    }

    .withdraw-field {
        width: 150px;
    }

    .withdraw-label {
        padding: 7px;
        margin-bottom: 0;
    }

    input {
        text-align: right;
    }

    .has-feedback .form-control {
        padding: 12px;
    }

    .balance-display-fix {
        margin-right: 13px;
    }
</style>