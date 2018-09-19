<template>
    <button class="btn btn-box-tool"
            title="Click to delete nicehash account"
            @click="confirmDelete"
            :disabled="isDeleting">
        <i class="fa fa-trash"></i>
    </button>
</template>

<script>
    import {mapActions} from 'vuex';

    export default {
        props: {
            nicehashAccountData: {
                type: Object,
                required: true
            }
        },
        data: () => ({
            isDeleting: false
        }),
        methods: {
            ...mapActions({
                deleteNicehashAccount: 'nicehash/deleteNicehashAccount'
            }),
            confirmDelete(event) {
                this.$SpinnerPlugin.showSpinner(event.currentTarget);
                this.isDeleting = true;
                this.$SweetAlertPlugin.cfmDialog('Are you sure want to delete nicehash account ' + this.nicehashAccountData.account_name + '?',
                    () => {
                        this.deleteNicehashAccount(this.nicehashAccountData)
                            .then(response => {
                                this.$awn.success(response.data.msg);
                            })
                            .catch(error => {
                                this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                            })
                            .finally(() => {
                                this.$SpinnerPlugin.hideSpinner(null, '<i class="fa fa-trash"></i>');
                                this.isDeleting = false;
                            });
                    },
                    () => {
                        this.$SpinnerPlugin.hideSpinner(null, '<i class="fa fa-trash"></i>');
                        this.isDeleting = false;
                    });
            }
        }
    }
</script>

<style scoped>

</style>