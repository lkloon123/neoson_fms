<template>
    <div>
        <div class="row" v-for="(farmDatas,index) in farmList">
            <div class="col-md-4" v-for="item in farmDatas" :key="item.id">
                <farm-item :init-farm-data="item"></farm-item>
            </div>

            <div class="col-md-4" v-if="index === farmList.length -1">
                <add-farm></add-farm>
            </div>
        </div>

        <div class="row" v-if="farmList <= 0">
            <div class="col-md-4">
                <add-farm></add-farm>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import FarmItem from './components/FarmItem/FarmItem';
    import AddFarm from './components/AddFarm';

    export default {
        computed: {
            ...mapGetters({
                farmList: 'farm/farmList',
                error: 'farm/error'
            }),
        },
        components: {
            FarmItem, AddFarm
        }
    }
</script>

<style scoped>

</style>