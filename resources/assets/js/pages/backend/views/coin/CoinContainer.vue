<template>
    <div>
        <coin-table :api-link="this.apiLink"
                    :data-setup="this.dataSetup"
                    :show-action="showAction"
                    action-link="/portal/coin/"
                    action-delete-title-key="coin_name"
                    delete-api-link="coin/"></coin-table>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import CoinTable from '../../../../components/DataTable';

    export default {
        data: () => ({
            apiLink: baseUrl + 'public/coin',
            dataSetup: [
                {
                    colHeader: 'Ticker',
                    apiDataKey: 'coin_ticker',
                    colProps: {
                        responsivePriority: 1,
                    }
                },
                {
                    colHeader: 'Coin Name',
                    apiDataKey: 'coin_name',
                    colProps: {
                        responsivePriority: 2,
                    }
                },
                {
                    colHeader: 'Explorer',
                    apiDataKey: 'explorer_link',
                    colType: 'url'
                },
                {
                    colHeader: 'Mineable',
                    apiDataKey: 'isMineable',
                    colType: 'boolean',
                    colProps: {
                        className: 'text-center'
                    }
                },
                {
                    colHeader: 'Status',
                    apiDataKey: 'available',
                    colType: 'boolean',
                    colProps: {
                        responsivePriority: 3,
                        className: 'text-center'
                    }
                },
                {
                    colHeader: 'Updated',
                    apiDataKey: 'updated_at',
                    colType: 'date_time',
                },
            ]
        }),
        computed: {
            ...mapGetters({
                isAdmin: 'user/isAdmin'
            }),
            showAction() {
                return this.isAdmin ? true : {view: true};
            }
        },
        components: {
            CoinTable
        }
    }
</script>

<style scoped>

</style>