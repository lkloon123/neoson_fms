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
            }
        },
        mounted() {
            if (this.validated === false) {
                this.$SweetAlertPlugin.basicDialog(this.errorMsg, 'error');
            } else {
                axios.post(baseUrl + 'auth/email/verify', {
                    email: this.email,
                    confirm_token: this.confirm_token
                }).then(response => {
                    this.$SweetAlertPlugin.basicDialog(response.data.msg, 'success',
                        () => {
                            this.$router.push('/login');
                        });
                }).catch(error => {
                    this.$SweetAlertPlugin.basicDialog(error.message, 'error',
                        () => {
                            this.$router.push('/login');
                        });
                });
            }
        },
        created() {
            if (this.email !== undefined && this.email !== null && this.email !== ''
                && this.confirm_token !== undefined && this.confirm_token !== null && this.confirm_token !== '') {
                this.validated = true;
                this.errorMsg = null;
            }
        }
    }
</script>

<style scoped>

</style>