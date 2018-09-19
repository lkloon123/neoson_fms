<template>
    <div class="box">
        <div class="box-header with-border" v-if="!isAdmin">
            <div :class="{ 'pull-right': supportTicket.length > 0, 'text-center': supportTicket.length <=0 }">
                <router-link to="ticket/create" class="btn btn-primary btn-xs">
                    <i class="fa fa-plus-circle"></i> Create A New Support Ticket
                </router-link>
            </div>
        </div>
        <div class="box-body" v-if="supportTicket.length > 0">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <ul class="nav nav-pills nav-stacked">
                        <support-ticket-item
                                v-for="item in this.supportTicket"
                                :key="item.id"
                                :init-support-ticket="item"></support-ticket-item>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import SupportTicketItem from './components/SupportTicketItem';

    export default {
        data: () => ({
            supportTicket: [],
        }),
        computed: {
            ...mapGetters({
                isAdmin: 'user/isAdmin'
            }),
        },
        methods: {
            getSupportTickets() {
                axios.get(baseUrl + 'support/ticket')
                    .then(response => {
                        this.supportTicket = response.data;
                    })
                    .catch(error => {
                    });
            }
        },
        components: {
            SupportTicketItem
        },
        mounted() {
            this.getSupportTickets();
        }
    }
</script>

<style scoped>

</style>