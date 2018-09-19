<template>
    <div>
        <wallet-control-table :api-link="apiLink" :data-setup="dataSetup" :show-action="false"></wallet-control-table>
    </div>
</template>

<script>
    import WalletControlTable from '../../../../../components/DataTable';

    export default {
        data: () => ({
            apiLink: baseUrl + 'public/walletcontrol/status',
            dataSetup: [
                {
                    colHeader: 'Coin Name',
                    apiDataKey: 'coin.coin_name',
                },
                {
                    colHeader: 'Ticker',
                    apiDataKey: 'coin.coin_ticker',
                    colProps: {
                        responsivePriority: 1,
                    }
                },
                {
                    colHeader: 'Version',
                    apiDataKey: 'version',
                    colProps: {
                        responsivePriority: 2
                    }
                },
                {
                    colHeader: 'Connection',
                    apiDataKey: 'connection',
                    colProps: {
                        responsivePriority: 3
                    }
                },
                {
                    colHeader: 'Updated At',
                    apiDataKey: 'updated_at',
                    colType: 'date_time',
                }
            ]
        }),
        components: {
            WalletControlTable
        }
    }
</script>

<style scoped>

</style>