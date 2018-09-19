<template>
    <div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <select-farm-box v-if="isLoading === false"></select-farm-box>
            </div>

            <div class="col-md-2"></div>
            <div class="col-md-4" v-if="shouldShowSelectCoinBox">
                <select-coin-box></select-coin-box>
            </div>
        </div>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <select-pool-box v-if="shouldShowSelectPoolBox"></select-pool-box>
            </div>

            <div class="col-md-2"></div>
            <div class="col-md-4" v-if="shouldShowInputTwoFactorBox">
                <input-two-factor-box></input-two-factor-box>
            </div>
        </div>
    </div>
</template>

<script>
    import SelectFarmBox from './components/SelectFarmBox';
    import SelectCoinBox from './components/SelectCoinBox';
    import SelectPoolBox from './components/SelectPoolBox';
    import InputTwoFactorBox from './components/InputTwoFactorBox';
    import {mapGetters} from 'vuex';

    export default {
        computed: {
            ...mapGetters({
                isLoading: 'remotestart/isLoading',
                selectedFarmList: 'remotestart/selectedFarmList',
                selectedCoin: 'remotestart/selectedCoin',
                selectedPool: 'remotestart/selectedPool'
            }),
            shouldShowSelectCoinBox() {
                return this.selectedFarmList.length > 0;
            },
            shouldShowSelectPoolBox() {
                return this.selectedFarmList.length > 0 && this.selectedCoin != null;
            },
            shouldShowInputTwoFactorBox() {
                return this.selectedFarmList.length > 0 && this.selectedCoin != null && this.selectedPool != null;
            }
        },
        components: {
            SelectFarmBox, SelectCoinBox, SelectPoolBox, InputTwoFactorBox
        }
    }
</script>

<style scoped>

</style>