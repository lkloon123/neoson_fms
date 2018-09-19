<template>
    <draggable :tag="{value: 'li'}">
        <a href="#" title="Click to edit miner"
           :class="{'bg-success': initMinerData.available, 'bg-danger': !initMinerData.available}"
           @click.prevent="showEdit"
           @mouseenter="showEditIcon = true"
           @mouseleave="showEditIcon = false">
            <span class="column-drag-handle pull-left" title="Drag to move miner between farms"
                  v-if="haveUpdatePermission">&#x2630;</span>
            {{ initMinerData.miner_name }}
            <span class="pull-right" v-if="showEditIcon === true">
                <i class="fa fa-edit"></i>
            </span>
        </a>

        <modal :name="editMinerModalName" :adaptive="true" :max-width="340" width="80%" height="auto">
            <miner-form mode="Edit" :init-miner-data="initMinerData" @modalClose="hideEdit"></miner-form>
        </modal>

    </draggable>
</template>

<script>
    import MinerForm from './MinerForm';
    import {Draggable} from 'vue-smooth-dnd';

    export default {
        props: [
            'initMinerData', 'haveUpdatePermission'
        ],
        data: () => ({
            showEditIcon: false
        }),
        computed: {
            editMinerModalName() {
                return 'edit-miner-' + this.initMinerData.id;
            }
        },
        methods: {
            showEdit() {
                if (!this.haveUpdatePermission) {
                    this.$SweetAlertPlugin.basicDialog('You Are Not Allow To Update Miner', 'error');
                    return;
                }
                this.showEditIcon = false;
                this.$modal.show(this.editMinerModalName);
            },
            hideEdit() {
                this.$modal.hide(this.editMinerModalName);
                this.showEditIcon = false;
            }
        },
        components: {
            MinerForm, Draggable
        }
    }
</script>

<style scoped>
    a {
        text-decoration: none;
    }

    .column-drag-handle {
        padding-right: 10px;
        cursor: move;
    }
</style>