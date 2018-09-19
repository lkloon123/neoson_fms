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
                    title: 'Pool Name',
                    value: 'pool_name'
                },
                {
                    title: 'Pool Stratum',
                    value: 'pool_stratum'
                },
                {
                    title: 'Pool API',
                    value: 'pool_api'
                },
                {
                    title: 'Pool Url',
                    value: 'pool_url',
                    type: 'url'
                },
                {
                    title: 'Type',
                    value: 'type'
                },
                {
                    title: 'Ticker',
                    value: 'ticker'
                },
                {
                    title: 'Algo',
                    value: 'algo'
                },
                {
                    title: 'Port',
                    value: 'port'
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
                return 'public/pool/' + this.$route.params.id;
            }
        },
        components: {
            DetailView
        }
    }
</script>

<style scoped>

</style>