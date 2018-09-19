<template>
    <div class="box box-primary box-solid">
        <div class="box-header with-border">
            <div class="box-title">Select A Miner</div>
            <div class="box-tools pull-right">
                <router-link to="/portal/farm" class="btn btn-box-tool" title="Click to go to farm setting">
                    <i class="fa fa-pencil"></i>
                </router-link>
            </div>
        </div>
        <div class="box-body">
            <multi-select v-model="selectedMiner"
                          :options="minerList(selectedFarm.id)"
                          @input="$emit('minerSelected', selectedMiner)"
                          track-by="id"
                          label="miner_name"
                          deselect-label=""
                          :allow-empty="false"
                          :searchable="true">
            </multi-select>
        </div>
        <loading-overlay v-if="isLoading"></loading-overlay>
    </div>
</template>

<script>
    import LoadingOverlay from './../../../../../../../components/LoadingOverlayForBox';
    import {mapActions, mapGetters} from 'vuex';
    import MultiSelect from 'vue-multiselect';

    export default {
        props: {
            selectedFarm: {
                type: Object,
                required: true
            }
        },
        watch: {
            selectedFarm() {
                this.selectedMiner = null;
            }
        },
        data: () => ({
            selectedMiner: null
        }),
        computed: {
            ...mapGetters({
                minerList: 'miner/minerList_search',
                isLoading: 'miner/isLoading'
            })
        },
        methods: {
            ...mapActions({
                loadMinerList: 'miner/loadMinerList'
            })
        },
        components: {
            MultiSelect, LoadingOverlay
        },
        created() {
            this.loadMinerList()
        }
    }
</script>

<style scoped>

</style>