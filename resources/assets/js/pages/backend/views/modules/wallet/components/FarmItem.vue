<template>
    <div class="box box-primary box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">{{ initFarmData.farm_name }}</h3>
            <div class="box-tools box-tools-fix pull-right">
                <small>Show 0 balance</small>
                <toggle-button v-model="showZeroBalance"
                               :sync="true"></toggle-button>
            </div>
        </div>
        <div class="box-body box-static-body no-padding">
            <vue-scroll>
                <ul class="nav nav-pills nav-stacked">
                    <coin-balance-item :init-wallet-balance="item"
                                       :show-zero-balance="showZeroBalance"
                                       v-for="item in loadWalletBalance"
                                       :key="item.id"></coin-balance-item>
                </ul>
            </vue-scroll>
        </div>
        <loading-overlay v-if="isLoading === true"></loading-overlay>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import LoadingOverlay from '../../../../../../components/LoadingOverlayForBox';
    import CoinBalanceItem from "./CoinBalanceItem";
    import ToggleButton from 'vue-js-toggle-button/src/Button';

    export default {
        props: {
            initFarmData: {
                type: Object,
                required: true
            }
        },
        data: () => ({
            showZeroBalance: false
        }),
        computed: {
            ...mapGetters({
                getWalletBalanceByFarm: 'walletbalance/getWalletBalanceByFarm',
                getWalletBalanceByFarmRemovedZero: 'walletbalance/getWalletBalanceByFarmRemovedZero',
                isLoading: 'walletbalance/isLoading'
            }),
            loadWalletBalance() {
                if (this.showZeroBalance === true) {
                    return this.getWalletBalanceByFarm(this.initFarmData.id);
                } else {
                    return this.getWalletBalanceByFarmRemovedZero(this.initFarmData.id);
                }
            }
        },
        components: {
            CoinBalanceItem, LoadingOverlay, ToggleButton
        },
    }
</script>

<style scoped>

</style>