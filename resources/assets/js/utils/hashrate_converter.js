export default (hashrate) => {
    console.log(hashrate);
    hashrate = parseInt(hashrate);

    if (hashrate > 1000000000000000) {
        return (hashrate / 1000000000000000).toFixed(2) + ' PH/s';
    }

    if (hashrate > 1000000000000) {
        return (hashrate / 1000000000000).toFixed(2) + ' TH/s';
    }

    if (hashrate > 1000000000) {
        return (hashrate / 1000000000).toFixed(2) + ' GH/s';
    }

    if (hashrate > 1000000) {
        return (hashrate / 1000000).toFixed(2) + ' MH/s';
    }

    if (hashrate > 1000) {
        return (hashrate / 1000).toFixed(2) + ' KH/s';
    }

    return hashrate + ' H/s';
}