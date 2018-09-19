<template>
    <div class="box box-solid box-primary no-margin">
        <div class="box-header">
            {{ initFarmData.farm_name }}'s Permission Manager
        </div>
        <div class="box-body">
            <h4 class="text-center" v-if="!isFinishedloadFarmUserListWithPermission">loading...</h4>
            <div v-if="isFinishedloadFarmUserListWithPermission">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr class="bg-primary">
                            <th>user</th>
                            <th class="text-center" v-for="permission in getFarmPermissionTextList">
                                {{ permission }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="farmUser in farmUserListWithPermission">
                            <td>{{ farmUser.name }}</td>
                            <td class="text-center" v-for="item in getFarmPermissionTextList">
                                <input type="checkbox" v-model="farmUser.permission[item]">
                            </td>
                        </tr>
                        <tr v-if="isFarmUserListEmpty">
                            <td class="text-center" colspan="5">You are the only one can access this farm</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer text-right" v-if="!isFarmUserListEmpty">
                    <div class="pull-left">
                        <button type="button" class="btn btn-danger" @click="handleSelectAll(false)">
                            (un)Select All
                        </button>
                        <button type="button" class="btn btn-success" @click="handleSelectAll(true)">
                            Select All
                        </button>
                    </div>
                    <button type="submit" class="btn btn-primary" @click="handleSave">Save</button>
                </div>
            </div>
        </div>

        <loading-overlay v-if="!isFinishedloadFarmUserListWithPermission"></loading-overlay>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import LoadingOverlay from '../../../../../components/LoadingOverlayForBox';

    export default {
        props: {
            initFarmData: {
                type: Object,
                required: true
            }
        },
        data: () => ({
            farmUserListWithPermission: [],
            isFinishedloadFarmUserListWithPermission: false,
        }),
        computed: {
            ...mapGetters({
                getFarmPermissionTextList: 'farm/getFarmPermissionTextList',
                getUserFarmPermissionListById: 'farm/getUserFarmPermissionListById'
            }),
            isFarmUserListEmpty() {
                return _.isEmpty(this.farmUserListWithPermission);
            }
        },
        methods: {
            loadFarmUserListWithPermission() {
                axios.get(baseUrl + 'farm/' + this.initFarmData.id + '/user/list')
                    .then(response => {
                        this.farmUserListWithPermission = response.data;
                    })
                    .catch(error => {
                        this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                        this.$emit('noPermission');
                    })
                    .finally(() => {
                        this.isFinishedloadFarmUserListWithPermission = true;
                    });
            },
            handleSave(event) {
                this.$SpinnerPlugin.showSpinner(event.currentTarget);
                axios.put(baseUrl + 'farm/' + this.initFarmData.id + '/user/list', {
                    farm_user_list: this.farmUserListWithPermission
                }).then(response => {
                    this.$SweetAlertPlugin.basicDialog(response.data.msg);
                }).catch(error => {
                    this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                }).finally(() => {
                    this.$SpinnerPlugin.hideSpinner();
                });
            },
            handleSelectAll(selectAll) {
                _.forEach(this.farmUserListWithPermission, user => {
                    _.forEach(user.permission, (permissionName, key) => {
                        user.permission[key] = selectAll;
                    });
                });
            }
        },
        components: {
            LoadingOverlay
        },
        created() {
            this.loadFarmUserListWithPermission();
        }
    }
</script>

<style scoped>
    .box.box-solid.box-primary > .box-body {
        color: #444;
    }

    .table th {
        min-width: 100px;
    }

    .table {
        margin-bottom: 0;
    }

    .box-footer {
        padding: 10px 0 0 0;
    }
</style>