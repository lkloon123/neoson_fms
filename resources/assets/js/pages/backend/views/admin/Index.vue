<template>
    <router-view></router-view>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        computed: {
            ...mapGetters({
                isAdmin: 'user/isAdmin'
            })
        },
        watch: {
            isAdmin() {
                this.checkUserRole();
            }
        },
        methods: {
            checkUserRole() {
                if (!this.isAdmin) {
                    this.$SweetAlertPlugin.basicDialog('You Are Not Allow To View This Page', 'error');
                    this.$router.push('/portal');
                }
            }
        },
        created() {
            this.checkUserRole();
        }
    }
</script>

<style scoped>

</style>