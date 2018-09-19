<template>
    <div class="direct-chat-msg" :class="{'right': postAtRightSide}">
        <div class="direct-chat-info clearfix">
            <span class="direct-chat-name" :class="{'pull-left': !postAtRightSide, 'pull-right': postAtRightSide}">
                {{ this.supportTicketMessage.post_by.name }}
            </span>
            <span class="direct-chat-timestamp"
                  :class="{'pull-right': !postAtRightSide, 'pull-left': postAtRightSide}">
                {{ this.supportTicketMessage.created_at }}
            </span>
        </div>

        <img class="direct-chat-img" :src="this.supportTicketMessage.post_by.profile_img">

        <div class="direct-chat-text">{{ this.supportTicketMessage.message }}</div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        props: [
            'initSupportTicketMessage'
        ],
        data: () => ({
            supportTicketMessage: this.initSupportTicketMessage,
        }),
        computed: {
            ...mapGetters({
                auth_user: 'user/auth_user',
                isAdmin: 'user/isAdmin'
            }),
            postAtRightSide() {
                if (this.isPostByUser && this.isAdmin) {
                    return true;
                }

                return !this.isPostByUser && !this.isAdmin;
            },
            isPostByUser() {
                return this.supportTicketMessage.post_by.id === this.auth_user.id;
            }
        },
        created() {
            this.supportTicketMessage = this.initSupportTicketMessage;
        }
    }
</script>

<style scoped>

</style>