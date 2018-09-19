<template>
    <strong>{{ price }}</strong>
</template>

<script>
    export default {
        data: () => ({
            price: null,
            loadCMCTask: null
        }),
        computed: {
            currency() {
                return this.$store.state.currency.id;
            }
        },
        watch: {
            currency() {
                this.loadCMC();
            }
        },
        methods: {
            loadCMC() {
                $.get('https://api.coinmarketcap.com/v2/ticker/1/?convert=' + this.currency)
                    .then(response => {
                        this.price = "1 BTC = " + response['data']['quotes'][this.currency.toUpperCase()]['price'].toFixed(2) +
                            " " + this.currency.toUpperCase();
                    })
                    .catch(error => {
                    });
            }
        },
        mounted() {
            this.loadCMC();
            this.loadCMCTask = setInterval(() => {
                this.loadCMC();
            }, 10 * 1000);
        },
        destroyed() {
            if (this.loadCMCTask) {
                clearInterval(this.loadCMCTask);
            }
        }
    }
</script>