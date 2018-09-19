<template>
    <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img :src="auth_user.profile_img" class="user-image">
            <span class="hidden-xs">{{ auth_user.name }}</span>
        </a>
        <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
                <img :src="auth_user.profile_img" class="img-circle">

                <p>
                    {{ auth_user.name }} {{ userRole }}
                    <small>Member since {{ registered_at }}</small>
                </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
                <div class="pull-left">
                    <!--<router-link :to="{ name: 'profile' }" class="btn btn-default btn-flat">Profile-->
                    <!--</router-link>-->
                </div>
                <div class="pull-right">
                    <button @click="logout" class="btn btn-default btn-flat">Logout</button>
                </div>
            </li>
        </ul>
    </li>
</template>

<script>
    import {mapGetters} from 'vuex';
    import moment from 'moment';
    import {dateTimeFormat} from "../../../../../env";

    export default {
        computed: {
            ...mapGetters({
                auth_user: 'user/auth_user'
            }),
            userRole() {
                if (this.auth_user.role) {
                    return '(' + this.auth_user.role + ')';
                }
            },
            registered_at() {
                return moment(this.auth_user.created_at, dateTimeFormat).format('MMM YYYY');
            }
        },
        methods: {
            logout() {
                this.$SweetAlertPlugin.cfmDialog("Do You Want To Logout?", () => {
                    this.$AuthPlugin.logout();
                    this.$store.dispatch('resetState');
                    this.$router.push('/');
                });
            }
        }
    }
</script>

<style scoped>

</style>