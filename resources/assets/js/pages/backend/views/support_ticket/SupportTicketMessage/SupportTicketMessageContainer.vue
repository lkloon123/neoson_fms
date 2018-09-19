<template>
    <div class="box support-ticket-message-box">
        <div class="box-header with-border">
            <span v-if="supportTicket != null" class="label support-ticket-status pull-right"
                  :class="{ 'bg-green': this.supportTicket.status !== 'closed', 'bg-red': this.supportTicket.status === 'closed' }">
                {{ this.supportTicket.status }}
            </span>
            <h3 class="title-header">
                <strong v-if="supportTicket != null">#{{ this.$route.params.id }}
                    {{ capitalizeSubject }}</strong>
            </h3>
        </div>

        <div class="box-body">
            <support-ticket-message-item v-for="item in this.supportTicketMessage"
                                         :key="item.id"
                                         :init-support-ticket-message="item"></support-ticket-message-item>
        </div>

        <div class="box-footer" v-if="this.supportTicket != null">
            <reply-form :init-action-status="this.supportTicket.status"
                        v-on:user-replied="refresh"></reply-form>
        </div>

    </div>
</template>

<script>
    import SupportTicketMessageItem from './components/SupportTicketMessageItem';
    import ReplyForm from './components/ReplyForm';

    export default {
        data: () => ({
            supportTicketMessage: [],
            supportTicket: null,
        }),
        computed: {
            capitalizeSubject() {
                return _.startCase(_.toLower(this.supportTicket.subject));
            }
        },
        methods: {
            getSupportTicketMessage() {
                axios.get(baseUrl + 'support/ticket/message/' + this.$route.params.id)
                    .then(response => {
                        this.supportTicketMessage = response.data;
                    })
                    .catch(error => {
                        this.$router.push('/portal/support');
                        this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                    });
            },
            getSupportTicket() {
                axios.get(baseUrl + 'support/ticket/' + this.$route.params.id)
                    .then(response => {
                        this.supportTicket = response.data;
                    })
                    .catch(error => {
                        //just ignore it
                    });
            },
            refresh() {
                this.getSupportTicket();
                this.getSupportTicketMessage();
            }
        },
        components: {
            SupportTicketMessageItem, ReplyForm
        },
        mounted() {
            this.refresh();
        }
    }
</script>

<style scoped>
    .support-ticket-message-box {
        border: 1px solid #d2d6de;
    }

    .title-header {
        display: inline-block;
        margin: 0;
        line-height: 1;
    }

    .support-ticket-status {
        margin-top: 7px;
        margin-right: 5px;
    }
</style>