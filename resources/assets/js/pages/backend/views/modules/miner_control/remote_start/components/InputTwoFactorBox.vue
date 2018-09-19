<template>
    <div class="box box-primary box-solid">
        <div class="box-header with-border">
            <div class="box-title">Enter Two Factor Code</div>
            <div class="box-tools pull-right">
                <router-link to="/portal/setting/twofactor" class="btn btn-box-tool" title="Click to go to two factor setting">
                    <i class="fa fa-pencil"></i>
                </router-link>
            </div>
        </div>
        <div class="box-body">
            <div class="form-group has-feedback"
                 :class="{ 'has-error': errors.has('Two Factor Authentication Code') }">
                <input type="password"
                       name="Two Factor Authentication Code"
                       v-model="twoFactorCode"
                       v-validate="'required|digits:6'"
                       class="form-control"
                       placeholder="6-digit authentication code"/>
            </div>
        </div>
        <div class="box-footer text-right">
            <submit-button :two-factor-code="twoFactorCode"></submit-button>
        </div>
    </div>
</template>

<script>
    import SubmitButton from './SubmitButton';

    export default {
        data: () => ({
            twoFactorCode: ''
        }),
        components: {
            SubmitButton
        }
    }
</script>

<style scoped>
    .box-body {
        height: 60px;
    }
</style>