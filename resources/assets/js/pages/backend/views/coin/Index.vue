<template>
    <div>
        <section class="content-header">
            <h1>
                Supported Coin
                <router-link to="/portal/coin/create"
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
    import {mapGetters} from 'vuex';

    export default {
        computed: {
            ...mapGetters({
                isAdmin: 'user/isAdmin'
            }),
            shouldShowCreate() {
                return this.$route.name !== 'coin_view'
                    && this.$route.name !== 'coin_create'
                    && this.$route.name !== 'coin_edit'
                    && this.isAdmin;
            }
        }
    }
</script>

<style scoped>

</style>