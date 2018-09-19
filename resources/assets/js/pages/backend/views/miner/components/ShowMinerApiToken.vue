<template xmlns:v-clipboard="http://www.w3.org/1999/xhtml">
    <div class="form-group input-group">
        <input class="form-control" type="text" v-model="apiToken" disabled="disabled"/>
        <span class="input-group-btn">
            <button type="button"
                    class="btn btn-info"
                    v-clipboard:copy="apiToken"
                    v-clipboard:success="onCopy"
                    title="Click to copy Api Token">
                <i class="fa fa-copy"></i>
            </button>
        </span>
    </div>
</template>

<script>
    export default {
        props: {
            apiToken: {
                type: String,
                required: true
            }
        },
        methods: {
            onCopy(event) {
                this.$awn.success('Api Token Copied!');
            }
        }
    }
</script>

<style scoped>

</style>