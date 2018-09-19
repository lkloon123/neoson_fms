<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Cronjobs\Wrapper;


use App\Models\MarketData;

class MarketWrapper
{
    public static function loadStockexchange($marketId, $marketDetail)
    {
        foreach ($marketDetail as $data) {
            $rawTicker = explode('_', $data->market_name);

            if ($rawTicker[1] === 'BTC') {
                MarketData::updateOrCreate(['ticker' => $rawTicker[0], 'market_id' => $marketId], [
                    'ticker' => $rawTicker[0],
                    'price' => (float)$data->last,
                    'volume' => (float)$data->vol,
                    'ask' => (float)$data->ask,
                    'bid' => (float)$data->bid,
                ]);
            }
        }
    }

    public static function loadCryptobridge($marketId, $marketDetail)
    {
        foreach ($marketDetail as $data) {
            $rawTicker = explode('_', $data->id);

            if ($rawTicker[1] === 'BTC') {
                MarketData::updateOrCreate(['ticker' => $rawTicker[0], 'market_id' => $marketId], [
                    'ticker' => $rawTicker[0],
                    'price' => (float)$data->last,
                    'volume' => (float)$data->volume,
                    'ask' => (float)$data->ask,
                    'bid' => (float)$data->bid,
                ]);
            }
        }
    }

    public static function loadMasternodexchange($marketId, $marketDetail)
    {
        foreach ($marketDetail as $key => $data) {
            if (ends_with(strtoupper($key), 'BTC')) {
                $ticker = strtoupper(substr($key, 0, -3));
                MarketData::updateOrCreate(['ticker' => $ticker, 'market_id' => $marketId], [
                    'ticker' => $ticker,
                    'price' => (float)$data->ticker->last,
                    'volume' => (float)$data->ticker->vol,
                    'ask' => (float)$data->ticker->sell,
                    'bid' => (float)$data->ticker->buy,
                ]);
            }
        }
    }

    public static function loadCoinmarketcap($marketId, $marketDetail)
    {
        foreach ($marketDetail as $data) {
            MarketData::updateOrCreate(['ticker' => $data->symbol, 'market_id' => $marketId], [
                'ticker' => $data->symbol,
                'price' => (float)$data->price_btc,
                'volume' => (float)$data->{'24h_volume_btc'},
            ]);
        }
    }

    public static function loadSouthxchange($marketId, $marketDetail)
    {
        foreach ($marketDetail as $data) {
            $rawTicker = explode('/', $data->Market);

            if ($rawTicker[1] === 'BTC') {
                MarketData::updateOrCreate(['ticker' => $rawTicker[0], 'market_id' => $marketId], [
                    'ticker' => $rawTicker[0],
                    'price' => (float)$data->Last,
                    'volume' => (float)$data->Volume24Hr,
                    'ask' => (float)$data->Ask,
                    'bid' => (float)$data->Bid,
                ]);
            }
        }
    }

    public static function loadCryptopia($marketId, $marketDetail)
    {
        foreach ($marketDetail->Data as $data) {
            $rawTicker = explode('/', $data->Label);

            if ($rawTicker[1] === 'BTC') {
                MarketData::updateOrCreate(['ticker' => $rawTicker[0], 'market_id' => $marketId], [
                    'ticker' => $rawTicker[0],
                    'price' => (float)$data->LastPrice,
                    'volume' => (float)$data->BaseVolume,
                    'ask' => (float)$data->AskPrice,
                    'bid' => (float)$data->BidPrice,
                ]);
            }
        }
    }

    public static function loadBittrex($marketId, $marketDetail)
    {
        foreach ($marketDetail->result as $data) {
            $rawTicker = explode('-', $data->MarketName);

            if ($rawTicker[0] === 'BTC') {
                MarketData::updateOrCreate(['ticker' => $rawTicker[1], 'market_id' => $marketId], [
                    'ticker' => $rawTicker[1],
                    'price' => (float)$data->Last,
                    'volume' => (float)$data->BaseVolume,
                    'ask' => (float)$data->Ask,
                    'bid' => (float)$data->Bid,
                ]);
            }
        }
    }

    public static function loadPoloniex($marketId, $marketDetail)
    {
        foreach ($marketDetail as $key => $data) {
            $rawTicker = explode('_', $key);

            if ($rawTicker[0] === 'BTC') {
                MarketData::updateOrCreate(['ticker' => $rawTicker[1], 'market_id' => $marketId], [
                    'ticker' => $rawTicker[1],
                    'price' => (float)$data->last,
                    'volume' => (float)$data->baseVolume,
                    'ask' => (float)$data->lowestAsk,
                    'bid' => (float)$data->highestBid,
                ]);
            }
        }
    }

    public static function loadBinance($marketId, $marketDetail)
    {
        foreach ($marketDetail as $data) {
            if (ends_with(strtoupper($data->symbol), 'BTC')) {
                $ticker = strtoupper(substr($data->symbol, 0, -3));
                MarketData::updateOrCreate(['ticker' => $ticker, 'market_id' => $marketId], [
                    'ticker' => $ticker,
                    'price' => (float)$data->lastPrice,
                    'volume' => (float)$data->quoteVolume,
                    'ask' => (float)$data->askPrice,
                    'bid' => (float)$data->bidPrice,
                ]);
            }
        }
    }

    public static function loadHitbtc($marketId, $marketDetail)
    {
        foreach ($marketDetail as $data) {
            if (ends_with(strtoupper($data->symbol), 'BTC')) {
                $ticker = strtoupper(substr($data->symbol, 0, -3));
                MarketData::updateOrCreate(['ticker' => $ticker, 'market_id' => $marketId], [
                    'ticker' => $ticker,
                    'price' => (float)$data->last,
                    'volume' => (float)$data->volumeQuote,
                    'ask' => (float)$data->ask,
                    'bid' => (float)$data->bid,
                ]);
            }
        }
    }

    public static function loadKucoin($marketId, $marketDetail)
    {
        foreach ($marketDetail->data as $data) {
            $rawTicker = explode('-', $data->symbol);

            if ($rawTicker[1] === 'BTC') {
                MarketData::updateOrCreate(['ticker' => $rawTicker[0], 'market_id' => $marketId], [
                    'ticker' => $rawTicker[0],
                    'price' => (float)$data->lastDealPrice,
                    'volume' => (float)$data->volValue,
                    'ask' => (float)$data->sell,
                    'bid' => (float)$data->buy,
                ]);
            }
        }
    }

    public static function loadOctaex($marketId, $marketDetail)
    {
        foreach ($marketDetail as $key => $data) {
            $rawTicker = explode('_', strtoupper($key));

            if ($rawTicker[1] === 'BTC') {
                MarketData::updateOrCreate(['ticker' => $rawTicker[0], 'market_id' => $marketId], [
                    'ticker' => $rawTicker[0],
                    'price' => (float)$data->new_price,
                    'volume' => (float)$data->amount,
                    'ask' => (float)$data->sell_price,
                    'bid' => (float)$data->buy_price,
                ]);
            }
        }
    }
}