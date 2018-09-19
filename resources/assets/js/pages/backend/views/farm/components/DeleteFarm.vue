<template>
    <button class="btn btn-box-tool" title="Click to delete farm" @click="confirmDelete" :disabled="isDeleting">
        <i class="fa fa-trash"></i>
    </button>
</template>

<script>
    import {mapActions} from 'vuex';

    export default {
        props: {
            farmData: {
                type: Object,
                required: true
            }
        },
        data: () => ({
            isDeleting: false
        }),
        methods: {
            ...mapActions({
                deleteFarm: 'farm/deleteFarm'
            }),
            confirmDelete(event) {
                this.$SpinnerPlugin.showSpinner(event.currentTarget);
                this.isDeleting = true;
                this.$SweetAlertPlugin.cfmDialog('Are you sure want to delete farm ' + this.farmData.farm_name + '?',
                    () => {
                        this.deleteFarm(this.farmData)
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