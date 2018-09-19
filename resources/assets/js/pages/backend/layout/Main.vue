<template>
    <div class="wrapper">
        <app-header></app-header>

        <app-sidebar></app-sidebar>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <router-view></router-view>
        </div>

        <app-footer></app-footer>

        <app-controlbar></app-controlbar>
    </div>
</template>

<script>
    import AppHeader from './Header/Header';
    import AppSidebar from './Sidebar/Sidebar';
    import AppFooter from './Footer';
    import AppControlbar from './Controlbar';

    export default {
        components: {
            AppHeader, AppSidebar, AppFooter, AppControlbar
        },
        created() {
            this.$store.dispatch('user/getUserData');
        },
        mounted() {
            //fix adminlte body split half error
            $('body').layout('fix');
        }
    }
</script>