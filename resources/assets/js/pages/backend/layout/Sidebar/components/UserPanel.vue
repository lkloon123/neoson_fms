<template>
    <div class="user-panel">
        <router-link to="/portal/setting/editprofile" class="pull-left image">
            <img :src="auth_user.profile_img" class="img-circle">
        </router-link>
        <div class="pull-left info">
            <p>{{ auth_user.name }}</p>
            <i class="fa fa-circle text-success"></i>
            <a href="#">
                <date-time></date-time>
            </a>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import DateTime from '../../../../../components/Datetime';

    export default {
        computed: {
            ...mapGetters({
                auth_user: 'user/auth_user'
            })
        },
        components: {
            DateTime
        },
    }
</script>

<style scoped>
    .user-panel > .image > img {
        height: 45px;
    }
</style>