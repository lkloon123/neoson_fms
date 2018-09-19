<template>

</template>

<script>
    export default {
        data: () => ({
            validated: false,
            errorMsg: 'There\'s some error, please make sure you click the correct link.',
        }),
        computed: {
            email() {
                return this.$route.query.e;
            },
            confirm_token() {
                return this.$route.query.t;
            },
            confirm_action() {
                return this.$route.query.a;
            }
        },
        mounted() {
            if (this.validated === false) {
                this.$SweetAlertPlugin.basicDialog(this.errorMsg, 'error');
            } else {
                axios.post(baseUrl + 'modules/withdrawal/process', {
                    email: this.email,
                    confirm_token: this.confirm_token,
                    confirm_action: this.confirm_action === 'true',
                }).then(response => {
                    this.$SweetAlertPlugin.basicDialog(response.data.msg, 'success',
                        () => {
                            this.$router.push('/portal/module/withdrawal/history');
                        });
                }).catch(error => {
                    this.$SweetAlertPlugin.basicDialog(error.message, 'error',
                        () => {
                            this.$router.push('/portal/module/withdrawal/history');
                        });
                });
            }
        },
        created() {
            if (this.email !== undefined && this.email !== null && this.email !== ''
                && this.confirm_token !== undefined && this.confirm_token !== null && this.confirm_token !== ''
                && this.confirm_action !== undefined && this.confirm_action !== null && this.confirm_action !== '') {
                this.validated = true;
                this.errorMsg = null;
            }
        }
    }
</script>

<style scoped>

</style>