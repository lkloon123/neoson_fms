<template>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">Details</h3>
                </div>
                <div class="box-body">
                    <detail-view :api-link="apiLink" :data-key="dataKey"></detail-view>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import DetailView from './../../../../components/DetailView';

    export default {
        data: () => ({
            dataKey: [
                {
                    title: 'Coin Name',
                    value: 'coin_name'
                },
                {
                    title: 'Coin Ticker',
                    value: 'coin_ticker'
                },
                {
                    title: 'Coin Algo',
                    value: 'coin_algo'
                },
                {
                    title: 'Explorer Link',
                    value: 'explorer_link',
                    type: 'url'
                },
                {
                    title: 'Explorer Type',
                    value: 'explorer_type'
                },
                {
                    title: 'Is Mineable?',
                    value: 'isMineable',
                    type: 'boolean'
                },
                {
                    title: 'Available',
                    value: 'available',
                    type: 'boolean'
                },
                {
                    title: 'Created At',
                    value: 'created_at'
                },
                {
                    title: 'Updated At',
                    value: 'updated_at'
                }
            ]
        }),
        computed: {
            apiLink() {
                return 'public/coin/' + this.$route.params.id;
            }
        },
        components: {
            DetailView
        }
    }
</script>

<style scoped>

</style>