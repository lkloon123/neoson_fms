<template>
    <button type="button" class="btn btn-info"
            @click="handleNotificationChange"
            :title="changeNotificationToolTip"
            :disabled="isUpdatingNotification"
            :class="{'bg-green': this.minerData.is_notification_enabled, 'bg-red': !this.minerData.is_notification_enabled}">
        <i class="fa fa-bell fa-lg" v-if="this.minerData.is_notification_enabled"></i>
        <i class="fa fa-bell-slash fa-lg" v-if="!this.minerData.is_notification_enabled"></i>
    </button>
</template>

<script>
    import {mapActions} from 'vuex';
    import ToggleButton from 'vue-js-toggle-button/src/Button';

    export default {
        props: {
            initMinerData: {
                type: Object,
                required: true
            },
        },
        data: () => ({
            isUpdatingNotification: false,
        }),
        computed: {
            minerData() {
                return Object.assign({}, this.initMinerData);
            },
            changeNotificationToolTip() {
                return 'Click to ' + (this.minerData.is_notification_enabled ? 'disable' : 'enable') + ' notification';
            },
        },
        methods: {
            ...mapActions({
                updateMiner: 'miner/updateMiner'
            }),
            handleNotificationChange(event) {
                this.isUpdatingNotification = true;
                this.updateMiner({
                    id: this.minerData.id,
                    is_notification_enabled: !this.minerData.is_notification_enabled
                })
                    .catch(error => {
                        this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                    })
                    .finally(() => {
                        this.isUpdatingNotification = false;
                    });
            },
        },
        components: {
            ToggleButton
        }
    }
</script>

<style scoped>

</style>