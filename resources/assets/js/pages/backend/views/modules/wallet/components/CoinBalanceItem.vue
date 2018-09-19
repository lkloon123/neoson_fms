<template>
    <li>
        <a href="#" @click.prevent="showModal">
            {{ coinName }}
            <span class="pull-right balance">
                {{ initWalletBalance.farm_balance }}
            </span>
        </a>

        <modal :name="showMinerBalanceModalName" :adaptive="true" :max-width="340" width="80%" height="auto">
            <show-miner-balance @modalClose="hideModal"
                                :init-wallet-balance="initWalletBalance"
                                :show-zero-balance="showZeroBalance"></show-miner-balance>
        </modal>
    </li>
</template>

<script>
    import ShowMinerBalance from "./ShowMinerBalance";

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
            showMinerBalanceModalName() {
                return 'show-miner-balance-' + this.initWalletBalance.id;
            }
        },
        methods: {
            showModal() {
                this.$modal.show(this.showMinerBalanceModalName);
            },
            hideModal() {
                this.$modal.hide(this.showMinerBalanceModalName);
            }
        },
        components: {
            ShowMinerBalance
        },
    }
</script>

<style scoped>

</style>