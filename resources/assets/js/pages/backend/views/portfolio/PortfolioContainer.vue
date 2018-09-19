<template>
    <div>
        <portfolio-table :api-link="this.apiLink" :data-setup="this.dataSetup" :show-action="false"></portfolio-table>
    </div>
</template>

<script>
    import PortfolioTable from '../../../../components/DataTable';

    export default {
        data: () => ({
            apiLink: baseUrl + 'monitor',
            dataSetup: [
                {
                    colHeader: 'Ticker',
                    apiDataKey: 'coin.coin_ticker'
                },
                {
                    colHeader: 'Balance',
                    apiDataKey: 'balance',
                    colProps: {
                        className: 'text-right'
                    }
                },
                {
                    colHeader: 'Market Price (BTC)',
                    apiDataKey: 'market_price',
                    colProps: {
                        className: 'text-right'
                    }
                },
                {
                    colHeader: 'Balance (BTC)',
                    apiDataKey: 'balance_in_btc',
                    colProps: {
                        className: 'text-right'
                    }
                },
            ]
        }),
        components: {
            PortfolioTable
        }
    }
</script>

<style scoped>

</style>