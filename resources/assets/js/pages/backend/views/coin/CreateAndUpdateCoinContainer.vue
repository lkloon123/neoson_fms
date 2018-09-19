<template>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{ mode }} Coin</h3>
                </div>
                <div class="box-body">
                    <div class="form-group has-feedback" :class="{ 'has-error': errors.has('Coin Name') }">
                        <label for="coin_name">Coin Name</label>
                        <input id="coin_name"
                               type="text"
                               name="Coin Name"
                               class="form-control"
                               placeholder="Coin Name"
                               v-model="coin_name"
                               v-validate="'required'">
                    </div>

                    <div class="form-group has-feedback" :class="{ 'has-error': errors.has('Coin Ticker') }">
                        <label for="coin_ticker">Coin Ticker</label>
                        <input id="coin_ticker"
                               type="text"
                               name="Coin Ticker"
                               class="form-control"
                               placeholder="Coin Ticker"
                               v-model="coin_ticker"
                               v-validate="'required'">
                    </div>

                    <div class="form-group has-feedback" :class="{ 'has-error': errors.has('Coin Algo') }">
                        <label for="coin_algo">Coin Algo</label>
                        <input id="coin_algo"
                               type="text"
                               name="Coin Algo"
                               class="form-control"
                               placeholder="Coin Algo"
                               v-model="coin_algo"
                               v-validate="'required'">
                    </div>

                    <div class="form-group">
                        <label for="explorer_link">Explorer Link</label>
                        <input id="explorer_link"
                               type="text"
                               name="Explorer Link"
                               class="form-control"
                               placeholder="Explorer Link"
                               v-model="explorer_link">
                    </div>

                    <div class="form-group">
                        <label for="explorer_type">Explorer Type</label>
                        <input id="explorer_type"
                               type="text"
                               name="Explorer Type"
                               class="form-control"
                               placeholder="Explorer Type"
                               v-model="explorer_type">
                    </div>

                    <div class="form-group no-margin">
                        <label class="checkbox-inline">
                            <input type="checkbox"
                                   v-model="isMineable">
                            is mineable?
                        </label>
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

    export default {
        data: () => ({
            id: null,
            coin_name: '',
            coin_ticker: '',
            coin_algo: '',
            explorer_link: '',
            explorer_type: 'common',
            isMineable: true,
            available: true,

            isLoading: false,
        }),
        computed: {
            mode() {
                return _.capitalize(_.last(this.$route.path.split('/')));
            }
        },
        methods: {
            handleSubmit() {
                let data = {
                    coin_name: this.coin_name,
                    coin_ticker: this.coin_ticker,
                    coin_algo: this.coin_algo,
                    explorer_link: this.explorer_link,
                    explorer_type: this.explorer_type,
                    isMineable: this.isMineable,
                    available: this.available,
                };

                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        if (this.mode === 'Edit') {
                            axios.put(baseUrl + 'coin/' + this.id, data).then(response => {
                                this.$router.push('/portal/coin');
                                this.$SweetAlertPlugin.basicDialog(response.data.msg);
                            }).catch(error => {
                                this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                            });
                        } else if (this.mode === 'Create') {
                            axios.post(baseUrl + 'coin', data).then(response => {
                                this.$router.push('/portal/coin');
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
            LoadingOverlay
        },
        mounted() {
            if (this.mode === 'Edit') {
                this.isLoading = true;
                this.id = this.$route.params.id;
                axios.get(baseUrl + 'public/coin/' + this.id)
                    .then(response => {
                        this.coin_name = response.data.coin_name;
                        this.coin_ticker = response.data.coin_ticker;
                        this.coin_algo = response.data.coin_algo;
                        this.explorer_link = response.data.explorer_link;
                        this.explorer_type = response.data.explorer_type;
                        this.isMineable = response.data.isMineable;
                        this.available = response.data.available;
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