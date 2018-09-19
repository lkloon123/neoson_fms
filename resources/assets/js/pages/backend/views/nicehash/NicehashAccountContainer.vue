<template>
    <div>
        <div class="row" v-for="(nicehashAccounts,index) in nicehashAccountList">
            <div class="col-md-4" v-for="item in nicehashAccounts" :key="item.id">
                <nicehash-account-item :init-nicehash-account-data="item"></nicehash-account-item>
            </div>

            <div class="col-md-4" v-if="index === nicehashAccountList.length -1">
                <add-nicehash-account></add-nicehash-account>
            </div>
        </div>

        <div class="row" v-if="nicehashAccountList <= 0">
            <div class="col-md-4">
                <add-nicehash-account></add-nicehash-account>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import NicehashAccountItem from "./components/NicehashAccountItem";
    import AddNicehashAccount from "./components/AddNicehashAccount";

    export default {
        computed: {
            ...mapGetters({
                nicehashAccountList: 'nicehash/nicehashAccountList',
                error: 'nicehash/error'
            }),
        },
        components: {
            NicehashAccountItem, AddNicehashAccount
        },
    }
</script>

<style scoped>

</style>