<template>
    <aside class="control-sidebar control-sidebar-dark" v-click-outside="onClickOutside">
        <!-- Content of the sidebar goes here -->
        <div class="content">
            <h4 class="control-sidebar-heading">General Settings</h4>
            <ul class="control-sidebar-menu">
                <li>
                    <router-link to="/portal/setting/editprofile" @click.native="onClickOutside">
                        <i class="menu-icon fa fa-user bg-blue"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">User Profile</h4>
                            <p>Edit User Profile</p>
                        </div>
                    </router-link>
                </li>
                <li>
                    <router-link to="/portal/setting/changepassword" @click.native="onClickOutside">
                        <i class="menu-icon fa fa-key bg-green"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Password</h4>
                            <p>Edit User Password</p>
                        </div>
                    </router-link>
                </li>
                <li>
                    <router-link to="/portal/setting/twofactor" @click.native="onClickOutside">
                        <i class="menu-icon fa fa-lock bg-red"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">2-FA Authentication</h4>
                            <p>Enhanced Security</p>
                        </div>
                    </router-link>
                </li>
                <li>
                    <router-link to="/portal/setting/notification" @click.native="onClickOutside">
                        <i class="menu-icon fa fa-bell bg-yellow"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Notification</h4>
                            <p>Email and Bot Notifcations</p>
                        </div>
                    </router-link>
                </li>
            </ul>
            <h4 class="control-sidebar-heading">Support</h4>
            <ul class="control-sidebar-menu">
                <li>
                    <router-link to="/portal/support/ticket" @click.native="onClickOutside">
                        <i class="menu-icon fa fa-question bg-primary"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Support Center</h4>
                            <p>Contact Support</p>
                        </div>
                    </router-link>
                </li>
                <li>
                    <a :href="telegramBotUrl" target="_blank">
                        <img class="menu-icon" src="/images/telegram_icon.png">
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Telegram Bot</h4>
                            <p>Your Personal Bot</p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
</template>

<script>
    import {telegramBotName} from '../../../env';

    export default {
        computed: {
            telegramBotUrl() {
                return 'https://telegram.me/' + telegramBotName;
            }
        },
        methods: {
            onClickOutside(event) {
                let element = $("aside");
                let isOpenBtn = ($(event.target).hasClass('fa-cogs') || event.target.hasAttribute('data-toggle'));
                if (element.hasClass("control-sidebar-open") && !isOpenBtn) {
                    element.removeClass("control-sidebar-open");
                }
            }
        }
    }
</script>

<style scoped>
    li > a {
        text-decoration: none;
    }
</style>