<template>
    <li class="dropdown notifications-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i>
            <span class="label label-danger" v-if="unreadCount > 0">{{ unreadCount }}</span>
        </a>
        <ul class="dropdown-menu">
            <li class="header">You have {{ notificationList.length }} notifications</li>
            <li>

                <vue-scroll>
                    <ul class="menu">
                        <li v-for="item in notificationList" :key="item.id" :class="{'unread-noti': !item.is_read}">
                            <notification-box :notification="item"></notification-box>
                        </li>
                    </ul>
                </vue-scroll>

            </li>
            <li class="footer">
                <a href="#" @click.prevent="markRead">Mark All As Read</a>
            </li>
        </ul>
    </li>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import NotificationBox from './NotificationBox';

    export default {
        data: () => ({
            loadNotificationTask: null
        }),
        computed: {
            ...mapGetters({
                notificationList: 'notification/notificationList',
                unreadCount: 'notification/unreadNotificationAmount'
            })
        },
        methods: {
            ...mapActions({
                loadNotificationList: 'notification/loadNotificationList',
                markAllAsReadOrUnread: 'notification/markAllAsReadOrUnread'
            }),
            markRead() {
                this.markAllAsReadOrUnread(true)
                    .catch(error => {
                    });
            }
        },
        components: {
            NotificationBox
        },
        created() {
            this.loadNotificationList().catch(error => {
            });
            this.loadNotificationTask = setInterval(() => {
                this.loadNotificationList().catch(error => {
                });
            }, 5000);
        },
        destroyed() {
            if (this.loadNotificationTask) {
                clearInterval(this.loadNotificationTask);
            }
        }
    }
</script>

<style scoped>
    .unread-noti {
        background-color: #edf2fa;
    }

    .navbar-nav > .notifications-menu > .dropdown-menu > li .menu {
        overflow-x: initial;
    }
</style>