<template>
    <div class="box box-primary box-solid">
        <div class="box-header with-border">
            <div class="box-title">{{ titleText }}</div>
            <div class="box-tools pull-right">
                <router-link to="/portal/farm" class="btn btn-box-tool" title="Click to go to farm setting">
                    <i class="fa fa-pencil"></i>
                </router-link>
            </div>
        </div>
        <div class="box-body" :class="{'text-center': !isUserHaveFarms}">
            <multi-select :value="selectedFarmList"
                          :multiple="true"
                          :options="options"
                          track-by="id"
                          label="farm_name"
                          @input="updateSelectedFarmList"
                          :searchable="true"
                          group-values="data"
                          group-label="selectAll"
                          :group-select="true"
                          v-if="isUserHaveFarms">
            </multi-select>
            <router-link to="/portal/farm" class="btn btn-primary" v-else>
                Go To Farm Setting
            </router-link>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import MultiSelect from 'vue-multiselect';

    export default {
        computed: {
            ...mapGetters({
                setupData: 'remotestart/setupData',
                selectedFarmList: 'remotestart/selectedFarmList'
            }),
            options() {
                return [{
                    selectAll: 'Select All',
                    data: this.setupData.farm_data
                }]
            },
            isUserHaveFarms() {
                return !_.isEmpty(this.setupData);
            },
            titleText() {
                return this.isUserHaveFarms ? 'Select A Farm' : 'Create Farm?'
            }
        },
        methods: {
            ...mapActions({
                updateSelectedFarmList: 'remotestart/updateSelectedFarmList'
            }),
        },
        components: {
            MultiSelect
        }
    }
</script>

<style scoped>

</style>