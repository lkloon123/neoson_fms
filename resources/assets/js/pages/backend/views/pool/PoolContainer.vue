<template>
    <div>
        <pool-table :api-link="this.apiLink"
                    :data-setup="this.dataSetup"
                    :show-action="showAction"
                    action-link="/portal/pool/"
                    action-delete-title-key="pool_name"
                    delete-api-link="pool/"></pool-table>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import PoolTable from '../../../../components/DataTable';

    export default {
        data: () => ({
            apiLink: baseUrl + 'public/pool',
            dataSetup: [
                {
                    colHeader: 'Pool Name',
                    apiDataKey: 'pool_name',
                    colProps: {
                        responsivePriority: 1,
                    }
                },
                {
                    colHeader: 'Pool Url',
                    apiDataKey: 'pool_url',
                    colType: 'url',
                },
                {
                    colHeader: 'Status',
                    apiDataKey: 'available',
                    colType: 'boolean',
                    colProps: {
                        responsivePriority: 2,
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
            PoolTable
        }
    }
</script>

<style scoped>

</style>