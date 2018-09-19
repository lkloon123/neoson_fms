<template>
    <div class="box box-primary box-solid">
        <box-header :init-farm-data="initFarmData" :miner-amount="minerList.length"
                    @showFarmPermission="showFarmPermission"></box-header>
        <div class="box-body box-static-body no-padding">
            <vue-scroll>
                <container class="box-static-body"
                           group-name="miner_update"
                           :get-child-payload="getPayload"
                           :tag="{value: 'ul', props: {class: 'nav nav-pills nav-stacked'}}"
                           @drop="processUpdateMiner"
                           drag-handle-selector=".column-drag-handle"
                           drag-class="opacity-ghost"
                           drop-class="opacity-ghost-drop"
                           :should-accept-drop="canMinerDragAndDrop">
                    <miner-item v-for="item in minerList"
                                :key="item.id"
                                :init-miner-data="item"
                                :have-update-permission="doUserHaveUpdatePermission(initFarmData.id)"></miner-item>
                </container>
            </vue-scroll>
        </div>
        <box-footer :init-farm-data="initFarmData"></box-footer>
        <loading-overlay v-if="isLoading === true"></loading-overlay>

        <modal :name="showFarmPermissionModalName" :adaptive="true" :max-width="600" width="80%" height="auto">
            <show-farm-permission :init-farm-data="initFarmData"
                                  @noPermission="hideFarmPermission"></show-farm-permission>
        </modal>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import MinerItem from '../../../miner/components/MinerItem';
    import LoadingOverlay from '../../../../../../components/LoadingOverlayForBox';
    import BoxHeader from './FarmItemHeader';
    import BoxFooter from './FarmItemFooter';
    import {Container} from 'vue-smooth-dnd';
    import ShowFarmPermission from './../ShowFarmPermission';

    export default {
        props: {
            initFarmData: {
                type: Object,
                required: true
            }
        },
        computed: {
            ...mapGetters({
                minerListSearch: 'miner/minerList_search',
                isLoading: 'miner/isLoading',
                doUserHaveUpdatePermission: 'farm/doUserHaveUpdatePermission',
            }),
            minerList() {
                return this.minerListSearch(this.initFarmData.id);
            },
            showFarmPermissionModalName() {
                return 'show-farm-permission-' + this.initFarmData.id;
            }
        },
        methods: {
            ...mapActions({
                updateMiner: 'miner/updateMiner'
            }),
            getPayload(index) {
                return this.minerList[index];
            },
            processUpdateMiner(event) {
                if (event.removedIndex === null && event.addedIndex === null) {
                    return;
                }
                if (event.removedIndex !== null && event.addedIndex !== null) {
                    return;
                }
                if (event.addedIndex !== null) {
                    this.updateMiner({
                        farm_id: this.initFarmData.id,
                        id: event.payload.id
                    }).then(response => {
                        this.$awn.success(response.data.msg);
                    }).catch(error => {
                        this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                    });
                }
            },
            showFarmPermission() {
                this.$modal.show(this.showFarmPermissionModalName);
            },
            hideFarmPermission() {
                this.$modal.hide(this.showFarmPermissionModalName);
            },
            canMinerDragAndDrop() {
                return this.doUserHaveUpdatePermission(this.initFarmData.id);
            }
        },
        components: {
            MinerItem, LoadingOverlay, BoxHeader, BoxFooter, Container, ShowFarmPermission
        }
    }
</script>

<style scoped>

</style>