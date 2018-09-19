<template>
    <nav class="navbar-inverse navbar-fixed-top navbar">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav_collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <router-link class="navbar-brand" to="/">NeoSon Crypto</router-link>
            </div>
            <div id="nav_collapse" class="collapse navbar-collapse">
                <ul class="navbar-nav navbar-right nav">
                    <router-link tag="li" to="/">
                        <a>Home</a>
                    </router-link>
                    <router-link v-if="isLogin" tag="li" to="/portal">
                        <a>Client Portal</a>
                    </router-link>
                    <li>
                        <a href="#" v-if="isLogin" @click="logout">Logout</a>
                    </li>
                    <router-link v-if="!isLogin" tag="li" to="/login">
                        <a>Login</a>
                    </router-link>
                    <router-link v-if="!isLogin" tag="li" to="/register">
                        <a>Register</a>
                    </router-link>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        computed: {
            ...mapGetters({
                auth_user: 'user/auth_user'
            }),
            isLogin() {
                return this.auth_user.id != null;
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
        },
        mounted() {
            //navbar fix for click
            $(document).on('click', '.navbar-collapse.in', function (e) {
                if ($(e.target).is('a:not(".dropdown-toggle")')) {
                    $(this).collapse('hide');
                }
            });
        }
    }
</script>

<style scoped>
    li > a {
        text-decoration: none;
    }
</style>