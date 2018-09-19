<template>
    <div>
        <section class="content-header">
            <h1>Notification</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="box">
                        <div class="box-header with-border text-center">
                            <h3 class="box-title">Notification Settings</h3>
                        </div>

                        <div class="box-body">
                            <div class="row form-group">
                                <div class="col-md-9 col-xs-9">Email Notification</div>
                                <div class="col-md-3 col-xs-3 text-right">
                                    <toggle-button
                                            v-if="userNotificationSetting !== null"
                                            v-model="userNotificationSetting.email_type_alert"
                                            @change="updateUserNotificationSetting"
                                            :sync="true"></toggle-button>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-9 col-xs-9">Website Notification</div>
                                <div class="col-md-3 col-xs-3 text-right">
                                    <toggle-button
                                            v-if="userNotificationSetting !== null"
                                            v-model="userNotificationSetting.web_type_alert"
                                            @change="updateUserNotificationSetting"
                                            :sync="true"></toggle-button>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-9 col-xs-9">Telegram Bot Notification</div>
                                <div class="col-md-3 col-xs-3 text-right">
                                    <toggle-button
                                            v-if="userNotificationSetting !== null"
                                            v-model="userNotificationSetting.telegram_type_alert"
                                            @change="updateUserNotificationSetting"
                                            :sync="true"></toggle-button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-9 col-xs-9">Facebook Bot Notification</div>
                                <div class="col-md-3 col-xs-3 text-right">
                                    <toggle-button
                                            v-if="userNotificationSetting !== null"
                                            v-model="userNotificationSetting.facebook_type_alert"
                                            @change="updateUserNotificationSetting"
                                            :sync="true"></toggle-button>
                                </div>
                            </div>
                        </div>
                        <loading-overlay v-if="isLoading"></loading-overlay>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import ToggleButton from 'vue-js-toggle-button/src/Button';
    import LoadingOverlay from '../../../../../components/LoadingOverlayForBox';

    export default {
        data: () => ({
            userNotificationSetting: null,
            isLoading: true,
        }),
        methods: {
            loadUserNotificationSetting() {
                this.isLoading = true;
                axios.get(baseUrl + 'setting/notification')
                    .then(response => {
                        this.userNotificationSetting = response.data;
                    })
                    .catch(error => {
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            },
            updateUserNotificationSetting() {
                this.isLoading = true;
                axios.put(baseUrl + 'setting/notification', this.userNotificationSetting)
                    .catch(error => {
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            }
        },
        components: {
            ToggleButton, LoadingOverlay
        },
        created() {
            this.loadUserNotificationSetting();
        }
    }
</script>

<style scoped>

</style>