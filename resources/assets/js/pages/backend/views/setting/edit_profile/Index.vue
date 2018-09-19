<template>
    <div>
        <section class="content-header">
            <h1>Edit User Profile</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="box">
                        <div class="box-header with-border text-center">
                            <profile-image-box :user-profile-img="auth_user.profile_img"></profile-image-box>
                        </div>
                        <div class="box-body">
                            <div class="form-group has-feedback" :class="{ 'has-error': errors.has('Full Name') }">
                                <label for="full_name">Full Name</label>
                                <input type="text"
                                       name="Full Name"
                                       id="full_name"
                                       v-model="name"
                                       class="form-control"
                                       placeholder="Full Name"
                                       v-validate="'required'"
                                       @keyup.enter="register">
                            </div>
                        </div>
                        <div class="box-footer text-right">
                            <button type="button" class="btn btn-primary" @click="handleSave">
                                Save
                            </button>
                        </div>
                        <loading-overlay v-if="isLoading === true"></loading-overlay>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import ProfileImageBox from './components/ProfileImageBox';
    import LoadingOverlay from '../../../../../components/LoadingOverlayForBox';

    export default {
        data: () => ({
            name: null
        }),
        computed: {
            ...mapGetters({
                auth_user: 'user/auth_user',
                isLoading: 'user/isLoading'
            })
        },
        watch: {
            auth_user(data) {
                this.name = data.name;
            }
        },
        methods: {
            ...mapActions({
                updateUser: 'user/updateUser'
            }),
            handleSave(event) {
                this.$SpinnerPlugin.showSpinner(event.target);
                this.updateUser({name: this.name})
                    .then(response => {
                        this.$SweetAlertPlugin.basicDialog(response.data.msg);
                    })
                    .catch(error => {
                        this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                    })
                    .finally(() => {
                        this.$SpinnerPlugin.hideSpinner();
                    });
            }
        },
        components: {
            ProfileImageBox, LoadingOverlay
        },
        mounted() {
            if (this.auth_user.name !== null && this.auth_user.name !== undefined) {
                this.name = this.auth_user.name;
            }
        }
    }
</script>

<style scoped>
    .form-group {
        margin-bottom: 0;
    }
</style>