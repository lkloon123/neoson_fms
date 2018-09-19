<template>
    <div class="reply-form">
        <div class="form-group has-feedback"
             :class="{ 'has-error': errors.has('Message') }"
             v-if="actionStatus !== 'closed'">
            <label class="control-label" for="message">Message</label>
            <textarea ref="message"
                      id="message"
                      name="Message"
                      class="form-control"
                      rows="5"
                      v-model="message"
                      v-validate="'required'">
                                </textarea>
        </div>

        <div class="text-right">
            <button type="submit" @click="handleChangeTicketStatus($event)" class="btn btn-default">
                {{ this.actionStatus === 'closed' ? 'Reopen' : 'Close' }} Ticket
            </button>
            <button type="submit" @click="handleSubmit($event)" class="btn btn-primary"
                    v-if="actionStatus !== 'closed'">
                Submit
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'initActionStatus'
        ],
        data: () => ({
            message: null,
            actionStatus: this.initActionStatus
        }),
        methods: {
            handleChangeTicketStatus(event) {
                this.$SweetAlertPlugin.cfmDialog('Do You Want To ' + (this.actionStatus === 'closed' ? 'Open' : 'Close') + ' This Ticket?',
                    () => {
                        this.$SpinnerPlugin.showSpinner(event.target);
                        axios.post(baseUrl + 'support/ticket/' + this.$route.params.id, {
                            status: this.actionStatus === 'closed' ? 'reopened' : 'closed'
                        }).then(response => {
                            this.actionStatus = this.actionStatus === 'closed' ? 'open' : 'closed';
                            this.$emit('user-replied');
                        }).catch(error => {
                            this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                        }).finally(() => {
                            this.$SpinnerPlugin.hideSpinner(this.actionStatus === 'closed' ? 'Open Ticket' : 'Close Ticket');
                        });
                    });
            },
            handleSubmit(event) {
                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        this.$SpinnerPlugin.showSpinner(event.target);
                        axios.post(baseUrl + 'support/ticket/message/' + this.$route.params.id, {
                            message: this.message
                        }).then(response => {
                            this.message = null;
                            this.$emit('user-replied');
                        }).catch(error => {
                            this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                        }).finally(() => {
                            this.$SpinnerPlugin.hideSpinner();
                        });
                    } else {
                        this.$SweetAlertPlugin.basicDialog(this.errors.all()[0], 'error');
                    }
                });
            }
        },
        mounted() {
            this.actionStatus = this.initActionStatus;
        }
    }
</script>

<style scoped>
    textarea {
        resize: none;
    }
</style>