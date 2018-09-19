<template>
    <div class="box box-primary box-solid">
        <div class="box-header with-border">
            <div class="box-title">Select A Coin</div>
        </div>
        <div class="box-body">
            <multi-select :value="selectedCoin"
                          :options="setupData.coin_data"
                          track-by="coin_name"
                          label="coin_name"
                          @input="updateSelectedCoin"
                          :allow-empty="false"
                          deselect-label="">
                <template slot="singleLabel" slot-scope="{ option }">
                    {{ option.coin_name }} ({{ option.coin_ticker }})
                </template>
                <template slot="option" slot-scope="{ option }">
                    {{ option.coin_name }} ({{ option.coin_ticker }})
                </template>
            </multi-select>
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
                selectedCoin: 'remotestart/selectedCoin'
            })
        },
        methods: {
            ...mapActions({
                updateSelectedCoin: 'remotestart/updateSelectedCoin'
            }),
        },
        components: {
            MultiSelect
        }
    }
</script>

<style scoped>

</style>