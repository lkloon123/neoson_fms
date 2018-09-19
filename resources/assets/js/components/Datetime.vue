<template>
    <span>{{now}}</span>
</template>

<script>
    import moment from 'moment';
    import {dateTimeFormat} from './../env';

    export default {
        data: () => ({
            now: moment().format(dateTimeFormat),
            updateDateTimeTask: null
        }),
        created() {
            this.updateDateTimeTask = setInterval(() => {
                this.now = moment().format(dateTimeFormat);
            }, 1000);
        },
        destroyed() {
            if (this.updateDateTimeTask) {
                clearInterval(this.updateDateTimeTask);
            }
        }
    }
</script>