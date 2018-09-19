<template>
    <div>
        <div class="row" v-for="(farmDatas) in farmList">
            <div class="col-md-4" v-for="item in farmDatas" :key="item.id">
                <farm-item :init-farm-data="item"></farm-item>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import FarmItem from "./components/FarmItem";

    export default {
        computed: {
            ...mapGetters({
                farmList: 'farm/farmList',
                error: 'farm/error'
            }),
        },
        components: {
            FarmItem
        },
    }
</script>

<style scoped>

</style>