<template>
    <div class="box-footer text-center">
        <a href="#" title="Click to add miner" @click.prevent="showAdd"
           v-if="doUserHaveUpdatePermission(initFarmData.id)">Add Miner</a>
        <span v-if="!doUserHaveUpdatePermission(initFarmData.id)">You Cannot Add Miner</span>

        <modal :name="addMinerModelName" :adaptive="true" :max-width="340" width="80%" height="auto">
            <miner-form mode="Add" :init-farm-data="initFarmData" @modalClose="hideAdd"></miner-form>
        </modal>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import MinerForm from './../../../miner/components/MinerForm';

    export default {
        props: {
            initFarmData: {
                type: Object,
                required: true
            },
        },
        computed: {
            ...mapGetters({
                doUserHaveUpdatePermission: 'farm/doUserHaveUpdatePermission',
            }),
            addMinerModelName() {
                return 'add-miner-' + this.initFarmData.id;
            }
        },
        methods: {
            showAdd() {
                this.$modal.show(this.addMinerModelName);
            },
            hideAdd() {
                this.$modal.hide(this.addMinerModelName);
            }
        },
        components: {
            MinerForm
        }
    }
</script>

<style scoped>

</style>