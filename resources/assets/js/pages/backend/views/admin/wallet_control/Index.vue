<template>
    <div>
        <section class="content-header">
            <h1>
                Wallet Control
                <router-link to="/portal/admin/walletcontrol/create"
                             class="btn btn-primary pull-right"
                             v-if="shouldShowCreate">
                    Create
                </router-link>
            </h1>
        </section>

        <section class="content">
            <router-view></router-view>
        </section>
    </div>
</template>

<script>
    export default {
        computed: {
            shouldShowCreate() {
                return this.$route.path !== '/portal/admin/walletcontrol/create';
            }
        }
    }
</script>

<style scoped>

</style>