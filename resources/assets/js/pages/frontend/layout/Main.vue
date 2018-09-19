<template>
    <div class="wrap">
        <app-header></app-header>

        <div class="container">
            <router-view></router-view>
        </div>

        <app-footer></app-footer>
    </div>
</template>

<script>
    import AppHeader from './Header';
    import AppFooter from './Footer';

    export default {
        components: {
            AppHeader, AppFooter
        },
        created() {
            this.$store.dispatch('user/getUserData');
        }
    }
</script>