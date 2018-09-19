<template>
    <div>
        <withdrawal-history-table :api-link="this.apiLink" :data-setup="this.dataSetup"
                                  :show-action="false" :show-index="false"
                                  :order-by="orderBy"></withdrawal-history-table>
    </div>
</template>

<script>
    import WithdrawalHistoryTable from '../../../../../components/DataTable';

    export default {
        data: () => ({
            apiLink: baseUrl + 'modules/withdrawal/history',
            orderBy: [5, 'desc'],
            dataSetup: [
                {
                    colHeader: 'ID',
                    apiDataKey: 'id',
                },
                {
                    colHeader: 'Coin',
                    apiDataKey: 'coin.coin_ticker',
                },
                {
                    colHeader: 'Amount',
                    apiDataKey: 'amount',
                },
                {
                    colHeader: 'Fee',
                    apiDataKey: 'fee',
                },
                {
                    colHeader: 'Status',
                    apiDataKey: 'status',
                },
                {
                    colHeader: 'Created',
                    apiDataKey: 'created_at',
                    colType: 'date_time',
                },
                {
                    colHeader: 'Address',
                    apiDataKey: 'withdraw_address'
                },
                {
                    colHeader: 'TXID',
                    apiDataKey: 'txid',
                },
            ]
        }),
        components: {
            WithdrawalHistoryTable
        }
    }
</script>

<style scoped>

</style>