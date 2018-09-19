<template>
    <div class="box box-primary box-solid">
        <div class="box-header with-border">
            <div class="box-title">Select A Pool</div>
        </div>
        <div class="box-body">
            <multi-select :value="selectedPool"
                          :options="setupDataForPoolList"
                          track-by="id"
                          label="pool_name"
                          @input="updateSelectedPool"
                          :allow-empty="false"
                          selectLabel=""
                          deselect-label="">
                <template slot="singleLabel" slot-scope="{ option }">
                    {{ option.pool_name }} ({{ option.hashrate }})
                </template>
                <template slot="option" slot-scope="{ option }">
                    {{ option.pool_name }} ({{ option.hashrate }})
                </template>
            </multi-select>
        </div>
        <loading-overlay v-if="isLoading === true"></loading-overlay>
    </div>
</template>

<script>
    import LoadingOverlay from '../../../../../../../components/LoadingOverlayForBox';
    import {mapActions, mapGetters} from 'vuex';
    import MultiSelect from 'vue-multiselect';

    export default {
        computed: {
            ...mapGetters({
                isLoading: 'remotestart/isLoadingPool',
                selectedPool: 'remotestart/selectedPool',
                setupDataForPoolList: 'remotestart/setupDataForPoolList'
            })
        },
        methods: {
            ...mapActions({
                updateSelectedPool: 'remotestart/updateSelectedPool'
            }),
        },
        components: {
            LoadingOverlay, MultiSelect
        }
    }
</script>

<style scoped>

</style>