<template>
    <li class="nav-item">
        <div class="label support-ticket-status pull-right"
             :class="{ 'bg-green': this.supportTicket.status !== 'closed', 'bg-red': this.supportTicket.status === 'closed' }">
            {{ this.supportTicket.status }}
        </div>
        <router-link class="support-ticket-items"
                     :to="'/portal/support/ticket/view/'+this.supportTicket.id">
            <dt><strong>#{{ this.supportTicket.id }}</strong> {{ this.supportTicket.subject }}</dt>
            <dd>
                <small class="text-muted">Update at {{ this.supportTicket.updated_at }}</small>
            </dd>
        </router-link>
    </li>
</template>

<script>
    export default {
        props: [
            'initSupportTicket'
        ],
        data: () => ({
            supportTicket: this.initSupportTicket
        }),
        created() {
            this.supportTicket = this.initSupportTicket;
            this.supportTicket.subject = _.startCase(_.toLower(this.supportTicket.subject));
        }
    }
</script>

<style scoped>
    .support-ticket-items {
        margin-right: 110px;
    }

    .support-ticket-status {
        margin-top: 20px;
        margin-right: 15px;
    }
</style>