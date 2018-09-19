<template>
    <div class="box box-primary box-solid">
        <div class="box-header with-border">
            <div class="box-title">Download</div>
        </div>
        <div class="box-body">
            <dl>
                <dt><a :href="downloadLink">NeoSon FMS Miner Control Launcher</a></dt>
                <dd class="text-sm text-muted" v-if="softwareInfoLoadFinish">{{ downloadInfo }}</dd>
            </dl>
        </div>
    </div>
</template>

<script>
    import filesize from 'file-size';
    import moment from 'moment';

    export default {
        data: () => ({
            softwareInfoLoadFinish: false,
            softwareInfo: {}
        }),
        computed: {
            downloadLink() {
                return baseUrl + 'modules/control/download/launcher';
            },
            softwareSize() {
                return filesize(this.softwareInfo.size).human('si');
            },
            releaseDate() {
                return moment.unix(this.softwareInfo.release).format('DD-MM-YYYY');
            },
            downloadInfo() {
                return 'Version: ' + this.softwareInfo.ver + ', Release: ' + this.releaseDate + ', Size: ' + this.softwareSize;
            }
        },
        created() {
            axios.get(baseUrl + 'modules/control/latest')
                .then(response => {
                    this.softwareInfo = response.data;
                    this.softwareInfoLoadFinish = true;
                })
                .catch(error => {
                });
        }
    }
</script>

<style scoped>
    dl {
        margin-bottom: 0;
    }
</style>