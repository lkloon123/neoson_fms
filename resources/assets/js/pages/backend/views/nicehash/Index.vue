<template>
    <div>
        <section class="content-header">
            <h1>Nicehash Setting</h1>
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
                nicehashAccountError: 'nicehash/error'
            })
        },
        methods: {
            ...mapActions({
                loadNicehashAccountList: 'nicehash/loadNicehashAccountList',
                resetNicehashAccountState: 'nicehash/resetStateData'
            }),
        },
        created() {
            this.loadNicehashAccountList().catch(() => {
                // this.$SweetAlertPlugin.basicDialog(this.nicehashAccountError, 'error');
            });
        },
        beforeDestroy() {
            this.resetNicehashAccountState();
        }
    }
</script>

<style scoped>

</style>