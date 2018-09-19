<template>
    <div class="box-header with-border">
        <h3 class="box-title" v-if="!isEditing">{{ farmData.farm_name }}</h3>
        <div class="box-tools pull-right" v-if="!isEditing">
            <span class="badge bg-aqua" :title="minerBadgeToolTip" v-if="minerAmount > 0">{{ minerAmount }}</span>
            <button class="btn btn-box-tool"
                    title="Click to edit farm permission"
                    @click="$emit('showFarmPermission')"
                    v-if="canUserModifyPermission(initFarmData.id)">
                <i class="fa fa-user"></i>
            </button>
            <button class="btn btn-box-tool"
                    title="Click to edit farm"
                    @click="isEditing = true"
                    v-if="doUserHaveUpdatePermission(initFarmData.id)">
                <i class="fa fa-pencil"></i>
            </button>
            <delete-farm-icon :farm-data="farmData"
                              v-if="doUserHaveDeletePermission(initFarmData.id)"></delete-farm-icon>
        </div>
        <inline-edit v-if="isEditing"
                     @inlineEditDone="processEditResult"
                     :text-to-edit="farmData.farm_name"></inline-edit>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import InlineEdit from '../../../../../../components/InlineEdit';
    import DeleteFarmIcon from '../DeleteFarm';

    export default {
        props: {
            initFarmData: {
                type: Object,
                required: true
            },
            minerAmount: {
                type: Number,
                required: true
            }
        },
        data: () => ({
            isEditing: false
        }),
        computed: {
            ...mapGetters({
                canUserModifyPermission: 'farm/canUserModifyPermission',
                doUserHaveUpdatePermission: 'farm/doUserHaveUpdatePermission',
                doUserHaveDeletePermission: 'farm/doUserHaveDeletePermission',
            }),
            farmData() {
                return this.initFarmData;
            },
            minerBadgeToolTip() {
                return 'Total Miner : ' + this.minerAmount;
            }
        },
        methods: {
            ...mapActions({
                updateFarm: 'farm/updateFarm'
            }),
            processEditResult({result, resultData, errorMsg}) {
                if (result === true) {
                    let changedFarmData = Object.assign({}, this.farmData);
                    changedFarmData.farm_name = resultData;
                    this.updateFarm(changedFarmData)
                        .then(response => {
                            this.$awn.success(response.data.msg);
                            this.isEditing = false;
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
            InlineEdit, DeleteFarmIcon
        }
    }
</script>

<style scoped>

</style>