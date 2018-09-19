<template>
    <div>
        <section class="content-header">
            <h1>Remote Start</h1>
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
                loadSetupError: 'remotestart/error'
            })
        },
        methods: {
            ...mapActions({
                loadSetupData: 'remotestart/loadSetupData',
                resetRemoteStartState: 'remotestart/resetStateData',
            })
        },
        created() {
            this.loadSetupData().catch(() => {
                this.$SweetAlertPlugin.basicDialog(this.loadSetupError, 'error');
            });
        },
        beforeDestroy() {
            this.resetRemoteStartState();
        }
    }
</script>

<style scoped>

</style>