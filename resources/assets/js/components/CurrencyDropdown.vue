<template>
    <v-select
            v-model="currency"
            track-by="label"
            label="label"
            :options="currencyOption"
            :searchable="true"
            :allow-empty="false"
            :close-on-select="true"
            :show-labels="false">
        <template slot="singleLabel" slot-scope="{ option }">{{ option.label }}</template>
    </v-select>
</template>

<script>
    import vSelect from 'vue-multiselect';

    export default {
        data: () => ({
            currencyOption: [
                {id: 'AUD', label: 'Australian Dollar'},
                {id: 'BRL', label: 'Brazilian Real'},
                {id: 'CAD', label: 'Canadian Dollar'},
                {id: 'CHF', label: 'Swiss Franc'},
                {id: 'CLP', label: 'Chilean Peso'},
                {id: 'CNY', label: 'Chinese Yuan'},
                {id: 'CZK', label: 'Czech Republic Koruna'},
                {id: 'DKK', label: 'Danish Krone'},
                {id: 'EUR', label: 'Euro'},
                {id: 'HKD', label: 'Hong Kong Dollar'},
                {id: 'HUF', label: 'Hungarian Forint'},
                {id: 'IDR', label: 'Indonesian Rupiah'},
                {id: 'ILS', label: 'Israeli New Shekel'},
                {id: 'INR', label: 'Indian Rupee'},
                {id: 'JPY', label: 'Japanese Yen'},
                {id: 'KRW', label: 'South Korean won'},
                {id: 'MXN', label: 'Mexican peso'},
                {id: 'MYR', label: 'Malaysian Ringgit'},
                {id: 'NOK', label: 'Norwegian Krone'},
                {id: 'NZD', label: 'New Zealand Dollar'},
                {id: 'PHP', label: 'Philippine Piso'},
                {id: 'PKR', label: 'Pakistani Rupee'},
                {id: 'PLN', label: 'Poland złoty'},
                {id: 'RUB', label: 'Russian Ruble'},
                {id: 'SEK', label: 'Swedish Krona'},
                {id: 'SGD', label: 'Singapore Dollar'},
                {id: 'THB', label: 'Thai Baht'},
                {id: 'TRY', label: 'Turkish lira'},
                {id: 'TWD', label: 'New Taiwan dollar'},
                {id: 'ZAR', label: 'South African Rand'}
            ]
        }),
        computed: {
            currency: {
                get() {
                    return this.$store.state.currency;
                },
                set(newValue) {
                    this.$store.commit('setCurrency', newValue);
                }
            },
        },
        components: {
            vSelect
        },
    }
</script>

<style scoped>

</style>