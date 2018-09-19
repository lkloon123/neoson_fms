<template>
    <table class="table table-striped table-bordered no-footer dtr-inline">
        <tbody v-if="!isLoading">
        <tr v-for="key in dataKey">
            <th class="col-xs-4 col-sm-4 col-md-4 col-lg-4">{{ key.title }}</th>
            <td class="col-xs-8 col-sm-48 col-md-8 col-lg-8" v-html="formatData(key.value, key.type)"></td>
        </tr>
        </tbody>

        <tbody v-else>
        <tr>
            <th class="text-center">Loading...</th>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: {
            apiLink: {
                type: String,
                required: true
            },
            dataKey: {
                type: Array,
                required: true,
            }
        },
        data: () => ({
            resultData: null,
            isLoading: true,
        }),
        methods: {
            loadData() {
                axios.get(baseUrl + this.apiLink)
                    .then(response => {
                        this.resultData = response.data;
                    })
                    .catch(error => {
                        this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            },
            formatData(value, type) {
                if (this.resultData === null) {
                    return '(Not Available)';
                }
                let data = this.resultData[value];

                if (!_.isEmpty(type)) {
                    if (type === 'url') {
                        return '<a href="' + _.escape(data) + '">' + _.escape(data) + '</a>';
                    } else if (type === 'boolean') {
                        return (data === true) ? '<i class="fa fa-check-circle fa-lg text-success"></i>'
                            : '<i class="fa fa-times-circle fa-lg text-danger"></i>';
                    }
                }

                if (_.isEmpty(data) || _.isNull(data)) {
                    return '(Not Available)';
                }

                return _.escape(data);
            }
        },
        created() {
            this.loadData();
        }
    }
</script>

<style scoped>
    table {
        table-layout: fixed;
        width: 100%;
    }

    @media (max-width: 768px) {
        .table td {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 320px;
        }
    }
</style>