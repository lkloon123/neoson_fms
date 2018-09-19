<template>
    <div>
        <section class="content-header">
            <h1>Farm Setting</h1>
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
                minerError: 'miner/error',
            })
        },
        methods: {
            ...mapActions({
                loadFarmList: 'farm/loadFarmList',
                loadMinerList: 'miner/loadMinerList',
                loadUserFarmPermissionList: 'farm/loadUserFarmPermissionList',
                loadFarmPermissionTextList: 'farm/loadFarmPermissionTextList',
                resetFarmState: 'farm/resetStateData',
                resetMinerState: 'miner/resetStateData'
            }),
        },
        created() {
            this.loadFarmList().catch(() => {
                // this.$SweetAlertPlugin.basicDialog(this.farmError, 'error');
            });

            this.loadMinerList().catch(() => {
                // this.$SweetAlertPlugin.basicDialog(this.minerError, 'error');
            });

            this.loadUserFarmPermissionList().catch(() => {
                // this.$SweetAlertPlugin.basicDialog(this.farmError, 'error');
            });

            this.loadFarmPermissionTextList().catch(() => {
                // this.$SweetAlertPlugin.basicDialog(this.farmError, 'error');
            });
        },
        beforeDestroy() {
            this.resetFarmState();
            this.resetMinerState();
        }
    }
</script>

<style scoped>

</style>