<template>
    <div class="alert" :class="alertTypeClass">
        <div class="container">
            <div class="row">
                <div class="col-xs-1 col-md-1 alert-icon-col">
                    <span :class="iconClass"></span>
                </div>
                <div class="col-xs-10 col-md-11">
                    {{ message }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['type', 'message', 'icon'],
        computed: {
            iconClass() {
                return 'fa ' + this.icon;
            },
            alertTypeClass() {
                return 'alert-' + this.type;
            }
        }
    }
</script>

<style scoped>
    .alert {
        border-radius: 0;
    }

    .alert .alert-icon-col {
        min-width: 25px;
        max-width: 25px;
    }
</style>