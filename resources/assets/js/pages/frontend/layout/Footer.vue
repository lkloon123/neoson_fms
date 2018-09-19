<template>
    <div class="footer">
        <div class="container">
            <p class="pull-left text-muted">
                <I>&copy; Copyright 2018 - {{ currentYear }} NeoSon Crypto</I>
            </p>
            <div class="pull-right hidden-xs">
                <bitcoin-price></bitcoin-price>
            </div>
        </div>
    </div>
</template>

<script>
    import BitcoinPrice from './../../../components/BitcoinPrice';

    export default {
        data: () => ({
            currentYear: (new Date()).getFullYear()
        }),
        components: {
            BitcoinPrice
        }
    }
</script>

<style scoped>
    .footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        height: 60px;
        line-height: 60px;
        background-color: #f5f5f5;
    }

    .footer > .container > p {
        margin: 0;
    }
</style>