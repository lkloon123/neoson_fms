<template>
    <div class="box box-solid box-primary no-margin">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ mode }} Miner
            </h3>
            <div class="box-tools box-tools-fix pull-right" v-if="isEditMode">
                <small>Status</small>
                <toggle-button v-model="minerData.available"
                               @change="handleStatusChange"
                               :title="changeStatusToolTip"
                               :disabled="isUpdatingStatus"
                               :sync="true"></toggle-button>
            </div>
        </div>
        <div class="box-body">
            <div class="form-group">
                <input ref="miner_name"
                       name="Miner Name"
                       type="text"
                       class="form-control"
                       v-model="minerData.miner_name"
                       placeholder="Miner Name"
                       @keyup.enter="handleSubmit">
            </div>

            <show-miner-api-token :api-token="minerData.api_token"
                                  v-if="isEditMode && showMinerApiToken"></show-miner-api-token>

            <div class="pull-left" v-if="isEditMode">
                <delete-miner :miner-data="initMinerData"></delete-miner>
            </div>
            <div class="pull-right">
                <miner-notification-setting :init-miner-data="initMinerData"
                                            v-if="isEditMode"></miner-notification-setting>
                <button type="button" class="btn btn-info"
                        @click="showMinerApiToken = !showMinerApiToken"
                        v-if="isEditMode"
                        :title="showMinerApiTokenToolTip">
                    <i class="fa fa-eye fa-lg" v-if="!showMinerApiToken"></i>
                    <i class="fa fa-eye-slash fa-lg" v-if="showMinerApiToken"></i>
                </button>
                <button type="button" @click="handleCancel" class="btn btn-danger" title="Click to discard changes">
                    <i class="fa fa-times-circle fa-lg"></i>
                </button>
                <button type="submit" @click="handleSubmit" class="btn btn-primary" title="Click to save changes">
                    <i class="fa fa-check-circle fa-lg"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';
    import DeleteMiner from './DeleteMiner';
    import ToggleButton from 'vue-js-toggle-button/src/Button';
    import ShowMinerApiToken from './ShowMinerApiToken';
    import MinerNotificationSetting from "./MinerNotificationSetting";

    export default {
        props: {
            mode: {
                validator: value => {
                    return ['Add', 'Edit'].indexOf(value) !== -1
                }
            },
            initMinerData: { //for edit
                type: Object,
                default: () => {
                    return {}
                }
            },
            initFarmData: Object, //for add
        },
        data: () => ({
            isUpdatingStatus: false,
            showMinerApiToken: false,
        }),
        computed: {
            minerData() {
                return Object.assign({}, this.initMinerData);
            },
            isEditMode() {
                return this.mode === 'Edit';
            },
            changeStatusToolTip() {
                return 'Click to change miner to ' + (this.minerData.available ? 'disable' : 'enable');
            },
            showMinerApiTokenToolTip() {
                let status = this.showMinerApiToken ? 'hide' : 'show';
                return 'Click to ' + status + ' miner Api Token';
            }
        },
        methods: {
            ...mapActions({
                addMiner: 'miner/addMiner',
                updateMiner: 'miner/updateMiner'
            }),
            handleStatusChange(event) {
                this.isUpdatingStatus = true;
                this.updateMiner({id: this.minerData.id, available: event.value})
                    .catch(error => {
                        this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                    })
                    .finally(() => {
                        this.isUpdatingStatus = false;
                    });
            },
            handleSubmit(event) {
                if (this.mode === 'Edit') {
                    if (this.initMinerData.miner_name === this.minerData.miner_name) {
                        this.$emit('modalClose');
                    } else {
                        this.$SpinnerPlugin.showSpinner(event.currentTarget);
                        this.updateMiner(this.minerData)
                            .then(response => {
                                this.$awn.success(response.data.msg);
                                this.$emit('modalClose');
                            })
                            .catch(error => {
                                this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                            })
                            .finally(() => {
                                this.$SpinnerPlugin.hideSpinner(null, '<i class="fa fa-check-circle fa-lg"></i>');
                            });
                    }
                } else if (this.mode === 'Add') {
                    this.$SpinnerPlugin.showSpinner(event.currentTarget);
                    this.minerData.farm_id = this.initFarmData.id;
                    this.addMiner(this.minerData) //save to db
                        .then(response => {
                            this.$awn.success(response.data.msg);
                            this.$emit('modalClose');
                        })
                        .catch(error => {
                            this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                        })
                        .finally(() => {
                            this.$SpinnerPlugin.hideSpinner(null, '<i class="fa fa-check-circle fa-lg"></i>');
                        });
                }
            },
            handleCancel(event) {
                this.$emit('modalClose');
            }
        },
        components: {
            MinerNotificationSetting, DeleteMiner, ToggleButton, ShowMinerApiToken
        }
    }
</script>

<style scoped>

</style>