<template>
    <image-upload-selector width="200" height="200"
                           margin="15" radius="50"
                           ref="selectedProfileImg"
                           :prefill="userProfileImg"
                           @change="onImageChange"
                           :zIndex="1"
                           title="Click Or Drop Image To Upload"></image-upload-selector>
</template>

<script>
    import {mapActions} from 'vuex';
    import ImageUploadSelector from 'vue-picture-input'

    export default {
        props: [
            'userProfileImg'
        ],
        methods: {
            ...mapActions({
                refreshUserData: 'user/getUserData'
            }),
            onImageChange() {
                let formData = new FormData();
                formData.append('profile_img', this.$refs.selectedProfileImg.file);
                axios.post(baseUrl + 'user', formData)
                    .then(response => {
                        this.refreshUserData();
                    })
                    .catch(error => {
                        this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                    });
            }
        },
        components: {
            ImageUploadSelector
        }
    }
</script>

<style scoped>

</style>