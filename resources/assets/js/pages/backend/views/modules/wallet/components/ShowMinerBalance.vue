<template>
    <div class="box box-solid box-primary no-margin">
        <div class="box-header with-border">
            <h3 class="box-title">{{ coinName }}</h3>
            <div class="box-tools pull-right" v-if="shouldShowWithdrawButton">
                <button class="btn btn-box-tool" title="Click to withdraw coin" @click="showModal">
                    <i class="fa fa-upload"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <ul class="list-unstyled">
                <li v-for="item in initWalletBalance.miner" :key="item.id" v-if="shouldShowZeroBalance(item)">
                    {{ item.miner_name }}
                    <span class="pull-right balance">{{ item.miner_balance }}</span>
                </li>
                <li class="total-balance">
                    <strong>
                        total<span class="pull-right balance">{{ initWalletBalance.farm_balance }}</span>
                    </strong>
                </li>
            </ul>
        </div>

        <modal :name="showWithdrawFormModalName" :adaptive="true" :max-width="350" width="80%" height="auto">
            <withdraw-form :init-miner-data="initWalletBalance.miner"
                           :selected-coin="initWalletBalance.coin"
                           :init-farm-data="initWalletBalance.farm"
                           @modalClose="hideModal"></withdraw-form>
        </modal>

    </div>
</template>

<script>
    import WithdrawForm from "../../withdrawal/components/WithdrawForm";

    export default {
        props: {
            initWalletBalance: {
                type: Object,
                required: true
            },
            showZeroBalance: {
                type: Boolean,
                required: true
            }
        },
        computed: {
            coinName() {
                return this.initWalletBalance.coin.coin_name +
                    ' (' + this.initWalletBalance.coin.coin_ticker + ')';
            },
            showWithdrawFormModalName() {
                return 'show-withdraw-form-' + this.initWalletBalance.id;
            },
            shouldShowWithdrawButton() {
                return this.initWalletBalance.farm_balance > 0 &&
                    this.initWalletBalance.canWithdraw === true;
            }
        },
        methods: {
            shouldShowZeroBalance(item) {
                return this.showZeroBalance ? this.showZeroBalance : item.miner_balance > 0;
            },
            showModal() {
                this.$modal.show(this.showWithdrawFormModalName);
            },
            hideModal() {
                this.$modal.hide(this.showWithdrawFormModalName);
            }
        },
        components: {
            WithdrawForm
        },
    }
</script>

<style scoped>
    ul > li > a {
        cursor: default;
    }

    ul > li {
        padding: 5px;
    }

    .total-balance {
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }
</style>