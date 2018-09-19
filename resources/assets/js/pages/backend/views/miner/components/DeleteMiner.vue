<template>
    <button class="btn btn-warning" @click="confirmDelete" :disabled="isDeleting" title="Click to delete miner">
        <i class="fa fa-trash"></i>
    </button>
</template>

<script>
    import {mapActions} from 'vuex';

    export default {
        props: {
            minerData: {
                type: Object,
                required: true
            }
        },
        data: () => ({
            isDeleting: false
        }),
        methods: {
            ...mapActions({
                deleteMiner: 'miner/deleteMiner'
            }),
            confirmDelete(event) {
                this.$SpinnerPlugin.showSpinner(event.currentTarget);
                this.isDeleting = true;
                this.$SweetAlertPlugin.cfmDialog('Are you sure want to delete miner ' + this.minerData.miner_name + '?',
                    () => {
                        this.deleteMiner(this.minerData)
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