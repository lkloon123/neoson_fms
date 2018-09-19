<template>
    <router-link :to="notification.action_link" @click.native="markAsRead">
        <i class="fa notification-icon" :class="iconClass"></i>
        <div class="notification-subject-container">
            <h6 class="notification-subject">{{ notification.subject }}</h6>
            <p class="notification-subject text-sm text-muted">{{ notificationDate }}</p>
        </div>
    </router-link>
</template>

<script>
    import {mapActions} from 'vuex';
    import moment from 'moment';
    import {dateTimeFormat} from './../../../../../env';

    export default {
        props: {
            notification: {
                type: Object,
                required: true
            }
        },
        computed: {
            notificationDate() {
                return moment(this.notification.created_at, dateTimeFormat).fromNow();
            },
            iconClass() {
                return {
                    'fa-question': this.notification.type === 'support',
                    'bg-primary': this.notification.type === 'support',

                    'fa-user': this.notification.type === 'user',
                    'bg-blue': this.notification.type === 'user'
                }
            }
        },
        methods: {
            ...mapActions({
                updateNotification: 'notification/updateNotification'
            }),
            markAsRead() {
                if (!this.notification.is_read) {
                    this.updateNotification({
                        id: this.notification.id,
                        is_read: true
                    }).catch(error => {
                    });
                }
            }
        }
    }
</script>

<style scoped>
    .notification-icon {
        float: left;
        width: 35px;
        height: 35px;
        line-height: 35px;
        border-radius: 50%;
        text-align: center
    }

    .notification-subject-container {
        margin-left: 45px;
        margin-top: 3px
    }

    .notification-subject {
        margin: 0;
    }

    .navbar-nav > .notifications-menu > .dropdown-menu > li .menu > li > a > .fa {
        width: 35px;
    }
</style>