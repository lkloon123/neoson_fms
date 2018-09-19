<template>
    <div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <system-requirements-item></system-requirements-item>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <download-item></download-item>
            </div>
        </div>
    </div>
</template>

<script>
    import SystemRequirementsItem from './components/SystemRequirementsItem';
    import DownloadItem from './components/DownloadItem';

    export default {
        components: {
            SystemRequirementsItem, DownloadItem
        }
    }
</script>

<style scoped>

</style>