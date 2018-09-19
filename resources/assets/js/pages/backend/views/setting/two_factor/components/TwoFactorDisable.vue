<template>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border text-center">
                    <h4>Disable Two-Factor Authentication</h4>
                </div>
                <div class="box-body text-center">
                    To disable your authenticator, please enter a two factor authentication code from your app
                </div>
                <div class="box-footer text-center">
                    <two-factor-form :link="'setting/twofa/disable'"></two-factor-form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import TwoFactorForm from "./TwoFactorForm";

    export default {
        components: {
            TwoFactorForm
        }
    }
</script>

<style scoped>

</style>