<template>
    <div class="box box-primary box-solid" v-if="!isLoading">
        <div class="box-header with-border">
            <div class="box-title">{{ titleText }}</div>
            <div class="box-tools pull-right">
                <router-link to="/portal/farm" class="btn btn-box-tool" title="Click to go to farm setting">
                    <i class="fa fa-pencil"></i>
                </router-link>
            </div>
        </div>
        <div class="box-body" :class="{'text-center': !isUserHaveFarms}">
            <multi-select v-model="selectedFarm"
                          :options="farmList"
                          @input="$emit('farmSelected', selectedFarm)"
                          track-by="id"
                          label="farm_name"
                          deselect-label=""
                          :allow-empty="false"
                          :searchable="true"
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
        data: () => ({
            selectedFarm: null
        }),
        computed: {
            ...mapGetters({
                farmList: 'farm/farmListWithoutChunk',
                isLoading: 'farm/isLoading'
            }),
            isUserHaveFarms() {
                return !_.isEmpty(this.farmList);
            },
            titleText() {
                return this.isUserHaveFarms ? 'Select A Farm' : 'Create Farm?'
            }
        },
        methods: {
            ...mapActions({
                loadFarmList: 'farm/loadFarmList'
            })
        },
        components: {
            MultiSelect
        },
        created() {
            this.loadFarmList()
        }
    }
</script>

<style scoped>

</style>