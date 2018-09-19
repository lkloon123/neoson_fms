<template>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="box box-solid box-primary">
                <div class="box-header text-center">
                    <h3 class="box-title">Create Wallet Control</h3>
                </div>
                <div class="box-body">
                    <div class="form-group has-feedback" :class="{ 'has-error': errors.has('RPC User') }">
                        <input type="text"
                               name="RPC User"
                               v-model="rpcUser"
                               class="form-control"
                               placeholder="RPC User"
                               v-validate="'required'">

                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback" :class="{ 'has-error': errors.has('RPC Password') }">
                        <input type="password"
                               name="RPC Password"
                               v-model="rpcPassword"
                               class="form-control"
                               placeholder="RPC Password"
                               v-validate="'required'">

                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback" :class="{ 'has-error': errors.has('RPC Port') }">
                        <input type="text"
                               name="RPC Port"
                               v-model="rpcPort"
                               class="form-control"
                               placeholder="RPC Port"
                               v-validate="'required|integer'">

                        <span class="fa fa-wrench form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback" :class="{ 'has-error': errors.has('RPC Host') }">
                        <input type="text"
                               name="RPC Host"
                               v-model="rpcHost"
                               class="form-control"
                               placeholder="RPC Host"
                               v-validate="'required'">

                        <span class="fa fa-compass form-control-feedback"></span>
                    </div>

                    <div class="form-group">
                        <multi-select v-model="selectedCoin"
                                      :options="coinList"
                                      track-by="coin_name"
                                      label="coin_name"
                                      :allow-empty="false"
                                      deselect-label="">
                            <template slot="singleLabel" slot-scope="{ option }">
                                {{ option.coin_name }} ({{ option.coin_ticker }})
                            </template>
                            <template slot="option" slot-scope="{ option }">
                                {{ option.coin_name }} ({{ option.coin_ticker }})
                            </template>
                        </multi-select>
                    </div>

                    <div class="text-center">
                        <button type="submit" @click="handleSubmit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import MultiSelect from 'vue-multiselect';

    export default {
        data: () => ({
            rpcUser: '',
            rpcPassword: '',
            rpcPort: '',
            rpcHost: '',
            selectedCoin: null,
            coinList: [],
            isLoadingCoin: true,
        }),
        methods: {
            loadCoinList() {
                axios.get(baseUrl + 'walletcontrol/setup/coinlist')
                    .then(response => {
                        this.coinList = response.data;
                    })
                    .catch(error => {
                        this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                    });
            },
            handleSubmit(event) {
                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        if (this.selectedCoin === null) {
                            this.$SweetAlertPlugin.basicDialog('Please Select A Coin', 'error');
                        } else {
                            this.$SpinnerPlugin.showSpinner(event.target);
                            axios.post(baseUrl + 'walletcontrol', {
                                rpc_user: this.rpcUser,
                                rpc_password: this.rpcPassword,
                                rpc_port: this.rpcPort,
                                rpc_host: this.rpcHost,
                                coin_id: this.selectedCoin.id
                            }).then(response => {
                                this.$router.push('/portal/admin/walletcontrol');
                                this.$SweetAlertPlugin.basicDialog(response.data.msg);
                            }).catch(error => {
                                this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                            }).finally(() => {
                                this.$SpinnerPlugin.hideSpinner();
                            });
                        }
                    } else {
                        this.$SweetAlertPlugin.basicDialog(this.errors.all()[0], 'error');
                    }
                });
            }
        },
        components: {
            MultiSelect
        },
        created() {
            this.loadCoinList();
        }
    }
</script>

<style scoped>
    .form-control-feedback {
        z-index: 1;
    }
</style>