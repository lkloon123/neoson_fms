<template>
    <div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <select-farm-box @farmSelected="updateSelectedFarm"></select-farm-box>
            </div>

            <div class="col-md-2"></div>
            <div class="col-md-4" v-if="selectedFarm !== null">
                <select-miner-box :selected-farm="selectedFarm" @minerSelected="updateChart"></select-miner-box>
            </div>
        </div>

        <div class="row" v-if="selectedMiner !== null">
            <div class="col-md-12">
                <div class="box box-primary box-solid">
                    <div class="box-header with-border text-center">
                        <strong class="pull-left">{{ displayCurrentMining }}</strong>
                        <h3 class="box-title">Hashrate last 5 min</h3>
                        <span class="pull-right hidden-xs">last update: {{ lastUpdateDate }}</span>
                    </div>
                    <div class="box-body">
                        <line-chart :chart-data="dataCollection" :width="1000" :height="330"
                                    :options="dataOption"></line-chart>
                    </div>
                    <div class="box-footer">
                        <span class="pull-right">
                            accepted : <span class="text-green">{{ lastAcceptedHash }}</span>
                            rejected : <span class="text-red">{{ lastRejectedHash }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LineChart from './../../../../../../components/LineChart';
    import SelectFarmBox from './components/SelectFarmBox';
    import SelectMinerBox from './components/SelectMinerBox';
    import moment from 'moment';

    export default {
        data: () => ({
            dataCollection: null,
            dataOption: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {display: false},
                tooltips: {
                    callbacks: {
                        label: function (tooltipItems) {
                            return tooltipItems.yLabel + ' MH/s';
                        }
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function (value) {
                                return value + ' MH/s';
                            }
                        }, scaleLabel: {
                            display: true,
                            labelString: 'hashrate MH/s'
                        }
                    }]
                }
            },
            minerSummaries: [],
            currentMining: null,
            updateMinerSummaryTask: null,
            selectedFarm: null,
            selectedMiner: null,
            lastUpdateDate: moment().format('hh:mm:ss a'),
        }),
        watch: {
            selectedFarm() {
                if (this.updateMinerSummaryTask) {
                    clearInterval(this.updateMinerSummaryTask);
                }
            }
        },
        computed: {
            displayCurrentMining() {
                if (this.currentMining !== null) {
                    return this.currentMining.coin_name + '(' + this.currentMining.coin_ticker + ')';
                }

                return 'Not mining';
            },
            lastAcceptedHash() {
                if (_.isEmpty(this.minerSummaries)) {
                    return 0;
                }
                return _.last(this.minerSummaries).accepted_hash;
            },
            lastRejectedHash() {
                if (_.isEmpty(this.minerSummaries)) {
                    return 0;
                }
                return _.last(this.minerSummaries).rejected_hash;
            }
        },
        methods: {
            loadMinerSummary(minerId) {
                axios.get(baseUrl + 'miner/summary/' + minerId)
                    .then(response => {
                        this.lastUpdateDate = moment().format('hh:mm:ss a');
                        this.minerSummaries = response.data.summary;
                        this.currentMining = response.data.current_mining;
                        this.fillData();
                    })
                    .catch(error => {

                    });
            },
            fillData() {
                this.dataCollection = {
                    labels: this.minerSummaries.map(summary => ""),
                    datasets: [
                        {
                            borderColor: 'rgb(0, 166, 90)',
                            backgroundColor: 'rgb(152, 251, 152, 0.5)',
                            data: this.minerSummaries.map(summary => summary.hashrate / 1000000)
                        }
                    ]
                }
            },
            updateSelectedFarm(value) {
                if (this.selectedFarm !== null) {
                    this.selectedFarm = null;
                    this.selectedMiner = null;
                }
                this.selectedFarm = value;
            },
            updateChart(value) {
                if (this.updateMinerSummaryTask) {
                    clearInterval(this.updateMinerSummaryTask);
                }
                this.selectedMiner = value;
                this.loadMinerSummary(value.id);
                this.updateMinerSummaryTask = setInterval(() => {
                    this.loadMinerSummary(value.id);
                }, 15000);
            }
        },
        components: {
            LineChart, SelectFarmBox, SelectMinerBox
        },
        destroyed() {
            if (this.updateMinerSummaryTask) {
                clearInterval(this.updateMinerSummaryTask);
            }
        }
    }
</script>

<style scoped>

</style>