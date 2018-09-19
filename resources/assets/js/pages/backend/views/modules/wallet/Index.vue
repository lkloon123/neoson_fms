<template>
    <div>
        <section class="content-header">
            <h1>Wallet Balance</h1>
        </section>

        <section class="content">
            <router-view></router-view>
        </section>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';

    export default {
        computed: {
            ...mapGetters({
                farmError: 'farm/error',
            })
        },
        methods: {
            ...mapActions({
                loadFarmList: 'farm/loadFarmList',
                resetFarmState: 'farm/resetStateData',
                loadWalletBalanceList: 'walletbalance/loadWalletBalanceList',
                resetWalletBalanceState: 'walletbalance/resetStateData'
            }),
        },
        created() {
            this.loadFarmList().catch(() => {
            });

            this.loadWalletBalanceList().catch(() => {
            });
        },
        beforeDestroy() {
            this.resetFarmState();
            this.resetWalletBalanceState();
        }
    }
</script>

<style scoped>

</style>