<template>
    <div class="box box-info box-solid">
        <div class="box-header with-border">
            <h3 class="box-title" v-if="!isEditing">Add New Farm</h3>
            <div class="box-tools pull-right" v-if="!isEditing">
                <button class="btn btn-box-tool" title="Click to add farm" @click="isEditing = true">
                    <i class="fa fa-plus-circle"></i>
                </button>
            </div>
            <inline-edit v-if="isEditing" @inlineEditDone="processAddResult"></inline-edit>
        </div>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';
    import InlineEdit from './../../../../../components/InlineEdit';

    export default {
        data: () => ({
            isEditing: false
        }),
        methods: {
            ...mapActions({
                addFarm: 'farm/addFarm'
            }),
            processAddResult({result, resultData, errorMsg}) {
                if (result === true) {
                    this.addFarm({farm_name: resultData}) //save to db
                        .then(response => {
                            this.$awn.success(response.data.msg);
                        })
                        .catch(error => {
                            this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                        })
                        .finally(() => {
                            this.isEditing = false;
                        });
                } else if (result === false) {
                    this.$SweetAlertPlugin.basicDialog(errorMsg, 'error');
                    this.isEditing = false;
                } else {
                    this.isEditing = false;
                }
            }
        },
        components: {
            InlineEdit
        }
    }
</script>

<style scoped>

</style>