<template>
    <table :id="this.id" class="table table-striped table-bordered dataTable no-footer dtr-inline" style="width: 100%">
        <thead>
        <tr class="bg-primary">
            <th v-for="col in colHeader">{{ col }}</th>
        </tr>
        </thead>
    </table>
</template>

<script>
    import Vue from 'vue';
    import router from './../routes';
    import 'datatable-sorting-datetime-moment';
    import {dateTimeFormat} from "../env";

    export default {
        props: {
            apiLink: {
                type: String,
                required: true
            },
            requiredAuth: {
                type: Boolean,
                default: true
            },
            showAction: {
                type: [Boolean, Object],
                default: false
            },
            actionLink: String,
            actionDeleteTitleKey: String,
            deleteApiLink: String,
            dataSetup: {
                type: Array,
                required: true
            },
            showIndex: {
                type: Boolean,
                default: true
            },
            orderBy: {
                type: Array,
                default: () => [1, 'asc']
            }
        },
        data: () => ({
            id: null,
            resultData: [],
            datatables: null,
            col: [],
            colDefs: [],
            colHeader: [],
        }),
        methods: {
            loadSetup() {
                let setup = this.dataSetup;

                if (this.showIndex === true) {
                    this.col.push({
                        data: null
                    });
                    this.colDefs.push({
                        searchable: false,
                        orderable: false,
                        targets: 0
                    });
                    this.colHeader.push('#');
                }

                for (let i = 0; i < setup.length; i++) {
                    if (setup[i].colHeader !== null && setup[i].colHeader !== undefined) {
                        this.colHeader.push(setup[i].colHeader);
                    } else {
                        this.colHeader.push(setup[i].apiDataKey);
                    }

                    let dataKey = {data: setup[i].apiDataKey};
                    dataKey.render = this.computedColumnType(setup[i]);
                    this.col.push(dataKey);

                    if (setup[i].colProps !== null && setup[i].colProps !== undefined) {
                        setup[i].colProps.targets = this.showIndex ? [i + 1] : i;
                        this.colDefs.push(setup[i].colProps);
                    }
                }

                if (this.showAction || typeof this.showAction === 'object') {
                    this.colHeader.push('Action');
                    this.col.push({
                        data: 'id', render: (data, type, row) => {
                            let tmp = '<div id="action_' + data + '" class="action_fix">';
                            if (typeof this.showAction === 'object') {
                                if (this.showAction.view === true) {
                                    tmp += ' <router-link to="' + this.actionLink + data + '"><i class="fa fa-eye fa-lg"></i></router-link>';
                                }

                                if (this.showAction.edit === true) {
                                    tmp += ' <router-link to="' + this.actionLink + data + '/edit"><i class="fa fa-pencil fa-lg"></i></router-link>';
                                }

                                if (this.showAction.delete === true) {
                                    tmp += ' <a href="#" @click.prevent="handleDelete"><i class="fa fa-trash fa-lg"></i></a>';
                                }
                            } else {
                                tmp += ' <router-link to="' + this.actionLink + data + '"><i class="fa fa-eye fa-lg"></i></router-link>'
                                    + ' <router-link to="' + this.actionLink + data + '/edit"><i class="fa fa-pencil fa-lg"></i></router-link>'
                                    + ' <a href="#" @click.prevent="handleDelete"><i class="fa fa-trash fa-lg"></i></a>';
                            }

                            return tmp + '</div>';
                        }
                    });
                    this.colDefs.push({
                        searchable: false,
                        orderable: false,
                        className: 'text-center',
                        targets: setup.length + 1
                    });
                }
            },
            computedColumnType(columnSetup) {
                let vm = this;

                if (columnSetup.colType) {
                    if (columnSetup.colType === 'boolean') {
                        return (data, type, row) => {
                            if (type === 'sort' || type === 'type') {
                                return data === true;
                            }

                            return (data === true) ? '<i class="fa fa-check-circle fa-lg text-success"></i>'
                                : '<i class="fa fa-times-circle fa-lg text-danger"></i>';
                        }
                    } else if (columnSetup.colType === 'url') {
                        return (data, type, row) => {
                            if (data !== null && data !== undefined && data !== '') {
                                return '<a href="' + _.escape(data) + '" target="_blank">' + _.escape(data) + '</a>';
                            }
                            return '(Not Available)';
                        }
                    } else if (columnSetup.colType === 'date_time') {
                        return (data, type, row) => {
                            return _.escape(data);
                        }
                    }
                }

                return (data, type, row) => {
                    if (data !== null && data !== undefined && data !== '') {
                        return _.escape(data.toString().replace(/-/g, ' '));
                    }

                    return '(Not Available)';
                };
            },
            reloadTable() {
                this.datatables.ajax.reload();
            },
            initVue(data, isChild = false) {
                let vm = this;
                new Vue({
                    el: isChild ? '#child_action_' + data.id : '#action_' + data.id,
                    router,
                    methods: {
                        handleDelete() {
                            vm.$SweetAlertPlugin.cfmDialog('Do You Want To Delete ' + _.get(data, vm.actionDeleteTitleKey).replace(/-/g, ' ') + '?',
                                () => {
                                    axios.delete(baseUrl + vm.deleteApiLink + data.id)
                                        .then(response => {
                                            vm.reloadTable();
                                            vm.$SweetAlertPlugin.basicDialog(response.data.msg);
                                        })
                                        .catch(error => {
                                            vm.$SweetAlertPlugin.basicDialog(error.message, 'error');
                                        });
                                });
                        }
                    }
                });
            }
        },
        created() {
            this.id = 'datatable_n' + this._uid;
            this.loadSetup();
        },
        mounted() {
            $.fn.dataTable.moment(dateTimeFormat);
            let vm = this;
            let datatables = $('#' + this.id).DataTable({
                responsive: {
                    details: {
                        renderer: function (api, rowIdx, columns) {
                            let data = $.map(columns, function (col) {
                                let tmp =
                                    '<li data-dtr-index="' + col.columnIndex + '" data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                                    '<span class="dtr-title">' + col.title + '</span>';
                                if (vm.showAction && col.columnIndex === columns.length - 1) {
                                    let id = $(col.data).attr('id').split('_')[1];
                                    tmp +=
                                        '<span class="dtr-data"><div id="child_action_' + id + '" class="action_fix">' + col.data + '</div></span>' +
                                        '</li>';
                                } else {
                                    tmp +=
                                        '<span class="dtr-data">' + col.data + '</span>' +
                                        '</li>';
                                }

                                return col.hidden ? tmp : '';
                            }).join('');

                            return data ?
                                $('<ul data-dtr-index="' + rowIdx + '" class="dtr-details">').append(data) :
                                false;
                        }
                    }
                },
                processing: true,
                order: [vm.orderBy],
                ajax: {
                    url: this.apiLink,
                    dataSrc: (response) => {
                        vm.resultData = response.data;
                        return response.data;
                    },
                    beforeSend: this.requiredAuth === false ? null : (request) => {
                        request.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('token'));
                    },
                    error: (error) => {
                        vm.$SweetAlertPlugin.basicDialog(_.startCase(_.toLower(error.responseJSON.error.message)), 'error');
                        $('#' + vm.id + '_processing').hide();
                        $('#' + vm.id).DataTable().clear().draw();
                    }
                },
                columns: this.col,
                columnDefs: this.colDefs,
                drawCallback: () => {
                    if (vm.showAction === true || typeof vm.showAction === 'object') {
                        for (let i = 0; i < vm.resultData.length; i++) {
                            if ($('#action_' + vm.resultData[i].id).length !== 0) {
                                //vue instance for action
                                vm.initVue(vm.resultData[i]);
                            }
                        }
                    }
                }
            });

            if (this.showIndex === true) {
                datatables.on('order.dt search.dt', () => {
                    datatables.column(0, {search: 'applied', order: 'applied'}).nodes().each((cell, i) => {
                        cell.innerHTML = i + 1;
                    });
                }).draw();
            }

            if (this.showAction === true || typeof this.showAction === 'object') {
                datatables.on('responsive-display', function (e, datatable, row, showHide, update) {
                    if (showHide === true) {
                        vm.initVue(row.data(), true);
                    }
                });
            }

            this.datatables = datatables;
        }
    }
</script>

<style scoped>

</style>