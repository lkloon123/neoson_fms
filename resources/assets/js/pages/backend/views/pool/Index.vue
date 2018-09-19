<template>
    <div>
        <section class="content-header">
            <h1>
                Supported Pool
                <router-link to="/portal/pool/create"
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
                return this.$route.name !== 'pool_view'
                    && this.$route.name !== 'pool_create'
                    && this.$route.name !== 'pool_edit'
                    && this.isAdmin;
            }
        }
    }
</script>

<style scoped>

</style>