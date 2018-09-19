<template>
    <footer class="main-footer">
        <div class="text-muted pull-right hidden-xs" v-if="version !== null">
            Version {{ version }}
        </div>
        <I class="text-muted">&copy; Copyright 2018 - {{ currentYear }} NeoSon Crypto</I>
    </footer>
</template>

<script>
    export default {
        data: () => ({
            version: null,
            currentYear: (new Date()).getFullYear()
        }),
        methods: {
            loadAppVersion() {
                axios.get(baseUrl + 'version')
                    .then(response => {
                        if (response.data.version) {
                            this.version = response.data.version;
                        }
                    })
                    .catch(error => {
                    });
            }
        },
        created() {
            this.loadAppVersion();
        }
    }
</script>