<template>
    <div>
        <section class="content-header">
            <h1>Dashboard</h1>
        </section>

        <section class="content">

            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><i class="fa fa-refresh fa-spin" v-if="totalFarm === null"></i>
                                <span v-else>{{ totalFarm }}</span></h3>
                            <p>Total Farms</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-home"></i>
                        </div>
                        <router-link to="/portal/farm" class="small-box-footer">
                            More Info
                            <i class="fa fa-arrow-circle-right"></i>
                        </router-link>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>
                                <i class="fa fa-refresh fa-spin" v-if="totalMiner === null"></i>
                                <span v-else>{{ totalMiner }}</span>
                            </h3>
                            <p>Total Miners</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-wrench"></i>
                        </div>
                        <router-link to="/portal/farm" class="small-box-footer">
                            More Info
                            <i class="fa fa-arrow-circle-right"></i>
                        </router-link>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>
                                <i class="fa fa-refresh fa-spin" v-if="totalNicehash === null"></i>
                                <span v-else>{{ totalNicehash }}</span>
                            </h3>
                            <p>Total Nicehashs</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-bitcoin"></i>
                        </div>
                        <router-link to="/portal/nicehash" class="small-box-footer">
                            More Info
                            <i class="fa fa-arrow-circle-right"></i>
                        </router-link>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>
                                <i class="fa fa-refresh fa-spin" v-if="totalPortfolio === null"></i>
                                <span v-else>{{ totalPortfolio }}</span>
                            </h3>
                            <p>Total Portfolios</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-eye"></i>
                        </div>
                        <router-link to="/portal/portfolio" class="small-box-footer">
                            More Info
                            <i class="fa fa-arrow-circle-right"></i>
                        </router-link>
                    </div>
                </div>
            </div>

        </section>
    </div>
</template>

<script>
    export default {
        data: () => ({
            totalFarm: null,
            totalMiner: null,
            totalNicehash: null,
            totalPortfolio: null,
        }),
        methods: {
            loadDashboardData() {
                axios.get(baseUrl + 'dashboard')
                    .then(response => {
                        this.totalFarm = response.data.total_farm;
                        this.totalMiner = response.data.total_miner;
                        this.totalNicehash = response.data.total_nicehash_account;
                        this.totalPortfolio = response.data.total_monitoring_coin;
                    })
                    .catch(error => {
                    });
            }
        },
        created() {
            this.loadDashboardData();
        }
    }
</script>

<style scoped>
    .small-box > .small-box-footer {
        z-index: auto;
    }
</style>