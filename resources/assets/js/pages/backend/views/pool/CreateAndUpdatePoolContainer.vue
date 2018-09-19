<template>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{ mode }} Pool</h3>
                </div>
                <div class="box-body">
                    <div class="form-group has-feedback" :class="{ 'has-error': errors.has('Pool Name') }">
                        <label for="pool_name">Pool Name</label>
                        <input id="pool_name"
                               type="text"
                               name="Pool Name"
                               class="form-control"
                               placeholder="Pool Name"
                               v-model="pool_name"
                               v-validate="'required'">
                    </div>

                    <div class="form-group has-feedback" :class="{ 'has-error': errors.has('Pool Stratum') }">
                        <label for="pool_stratum">Pool Stratum</label>
                        <input id="pool_stratum"
                               type="text"
                               name="Pool Stratum"
                               class="form-control"
                               placeholder="Pool Stratum"
                               v-model="pool_stratum"
                               v-validate="'required'">
                    </div>

                    <div class="form-group has-feedback" :class="{ 'has-error': errors.has('Pool API') }">
                        <label for="pool_api">Pool API</label>
                        <input id="pool_api"
                               type="text"
                               name="Pool API"
                               class="form-control"
                               placeholder="Pool API"
                               v-model="pool_api"
                               v-validate="'required'">
                    </div>

                    <div class="form-group has-feedback" :class="{ 'has-error': errors.has('Pool URL') }">
                        <label for="pool_url">Pool URL</label>
                        <input id="pool_url"
                               type="text"
                               name="Pool URL"
                               class="form-control"
                               placeholder="Pool URL"
                               v-model="pool_url"
                               v-validate="'required'">
                    </div>

                    <div class="form-group">
                        <label for="pool_type">Pool Type</label>
                        <multi-select id="pool_type"
                                      v-model="selectedType"
                                      :options="type"
                                      deselect-label=""
                                      :allow-empty="false"
                                      :searchable="true">
                        </multi-select>
                    </div>

                    <div v-if="shouldShowOtherOption">
                        <div class="form-group">
                            <label for="ticker">Ticker</label>
                            <input id="ticker"
                                   type="text"
                                   name="Ticker"
                                   class="form-control"
                                   placeholder="Ticker"
                                   v-model="ticker">
                        </div>

                        <div class="form-group">
                            <label for="algo">Algo</label>
                            <input id="algo"
                                   type="text"
                                   name="Algo"
                                   class="form-control"
                                   placeholder="Algo"
                                   v-model="algo">
                        </div>

                        <div class="form-group">
                            <label for="port">Port</label>
                            <input id="port"
                                   type="text"
                                   name="Port"
                                   class="form-control"
                                   placeholder="Port"
                                   v-model="port">
                        </div>
                    </div>

                    <div class="form-group no-margin">
                        <label class="checkbox-inline">
                            <input type="checkbox"
                                   v-model="available">
                            available?
                        </label>
                    </div>
                </div>
                <div class="box-footer text-right">
                    <button type="submit" class="btn btn-info" @click="$router.back()">
                        Back
                    </button>
                    <button type="submit" class="btn btn-primary" @click="handleSubmit">
                        Submit
                    </button>
                </div>

                <loading-overlay v-if="isLoading"></loading-overlay>
            </div>
        </div>
    </div>
</template>

<script>
    import LoadingOverlay from './../../../../components/LoadingOverlayForBox';
    import MultiSelect from 'vue-multiselect';

    export default {
        data: () => ({
            id: null,
            pool_name: '',
            pool_stratum: '',
            pool_api: '',
            pool_url: '',
            available: true,
            type: ['yiimp', 'oep', 'mpos'],
            selectedType: 'yiimp',

            shouldShowOtherOption: false,
            ticker: '',
            algo: '',
            port: '',

            isLoading: false,
        }),
        computed: {
            mode() {
                return _.capitalize(_.last(this.$route.path.split('/')));
            }
        },
        watch: {
            selectedType(newValue) {
                this.shouldShowOtherOption = newValue !== 'yiimp';
            }
        },
        methods: {
            handleSubmit() {
                let data = {
                    pool_name: this.pool_name,
                    pool_stratum: this.pool_stratum,
                    pool_api: this.pool_api,
                    pool_url: this.pool_url,
                    available: this.available,
                };

                if (!_.isNull(this.selectedType) && this.selectedType !== 'yiimp') {
                    data.type = this.selectedType;
                    data.ticker = this.ticker;
                    data.algo = this.algo;
                    data.port = this.port;
                }

                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        if (this.mode === 'Edit') {
                            axios.put(baseUrl + 'pool/' + this.id, data).then(response => {
                                this.$router.push('/portal/pool');
                                this.$SweetAlertPlugin.basicDialog(response.data.msg);
                            }).catch(error => {
                                this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                            });
                        } else if (this.mode === 'Create') {
                            axios.post(baseUrl + 'pool', data).then(response => {
                                this.$router.push('/portal/pool');
                                this.$SweetAlertPlugin.basicDialog(response.data.msg);
                            }).catch(error => {
                                this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                            });
                        }
                    } else {
                        this.$SweetAlertPlugin.basicDialog(this.errors.all()[0], 'error');
                    }
                });
            }
        },
        components: {
            LoadingOverlay, MultiSelect
        },
        mounted() {
            if (this.mode === 'Edit') {
                this.isLoading = true;
                this.id = this.$route.params.id;
                axios.get(baseUrl + 'public/pool/' + this.id)
                    .then(response => {
                        this.pool_name = response.data.pool_name;
                        this.pool_stratum = response.data.pool_stratum;
                        this.pool_api = response.data.pool_api;
                        this.pool_url = response.data.pool_url;
                        this.available = response.data.available;
                        this.selectedType = response.data.type;
                        this.ticker = response.data.ticker;
                        this.algo = response.data.algo;
                        this.port = response.data.port;
                    })
                    .catch(error => {
                        this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            }
        }
    }
</script>

<style scoped>

</style>