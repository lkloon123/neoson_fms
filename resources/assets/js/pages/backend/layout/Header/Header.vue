<template>
    <header class="main-header">
        <!-- Logo -->
        <router-link to="/portal" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">NSC</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">NeoSon Crypto</span>
        </router-link>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <notification-container></notification-container>

                    <user-profile></user-profile>

                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-cogs"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</template>

<script>
    import UserProfile from "./components/UserProfile";
    import NotificationContainer from "./components/NotificationContainer";

    export default {
        components: {
            UserProfile, NotificationContainer
        }
    }
</script>

<style scoped>
    a {
        text-decoration: none;
    }
</style>