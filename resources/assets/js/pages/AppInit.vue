<template>
    <div>
        <router-view></router-view>

        <div v-if="showLoader" class="loader_container">
            <spring-spinner
                    :animation-duration="1000"
                    :size="60"
                    :color="'#ff1d5e'"></spring-spinner>
        </div>
    </div>
</template>

<script>
    import {SpringSpinner} from 'epic-spinners';

    export default {
        computed: {
            showLoader() {
                return this.$store.getters.showLoader;
            }
        },
        components: {
            SpringSpinner
        },
        beforeCreate() {
            this.$store.commit('setCurrency');
        }
    }
</script>

<style scoped>

</style>