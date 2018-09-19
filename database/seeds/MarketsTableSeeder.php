<?php

use App\Models\Market;
use Illuminate\Database\Seeder;

class MarketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Market::create([
            'market_name' => 'stockexchange',
            'market_api' => 'https://stocks.exchange/api2/ticker',
            'available' => true,
        ]);

        Market::create([
            'market_name' => 'cryptobridge',
            'market_api' => 'https://api.crypto-bridge.org/api/v1/ticker',
            'available' => true,
        ]);

        Market::create([
            'market_name' => 'masternodexchange',
            'market_api' => 'https://masternodexchange.com/api/v2/tickers',
            'available' => true,
        ]);

        Market::create([
            'market_name' => 'coinmarketcap',
            'market_api' => 'https://api.coinmarketcap.com/v1/ticker/?convert=BTC&limit=0',
            'available' => true,
        ]);

        Market::create([
            'market_name' => 'southxchange',
            'market_api' => 'https://www.southxchange.com/api/prices',
            'available' => true,
        ]);

        Market::create([
            'market_name' => 'cryptopia',
            'market_api' => 'https://www.cryptopia.co.nz/api/GetMarkets',
            'available' => true,
        ]);

        Market::create([
            'market_name' => 'bittrex',
            'market_api' => 'https://bittrex.com/api/v1.1/public/getmarketsummaries',
            'available' => true,
        ]);

        Market::create([
            'market_name' => 'poloniex',
            'market_api' => 'https://poloniex.com/public?command=returnTicker',
            'available' => true,
        ]);

        Market::create([
            'market_name' => 'binance',
            'market_api' => 'https://api.binance.com/api/v1/ticker/24hr',
            'available' => true,
        ]);

        Market::create([
            'market_name' => 'hitbtc',
            'market_api' => 'https://api.hitbtc.com/api/2/public/ticker',
            'available' => true,
        ]);

        Market::create([
            'market_name' => 'kucoin',
            'market_api' => 'https://api.kucoin.com/v1/open/tick',
            'available' => true,
        ]);

        Market::create([
            'market_name' => 'octaex',
            'market_api' => 'https://octaex.com/api/trade/all/',
            'available' => true,
        ]);

        $this->command->info('Total Record -> ' . Market::all()->count());
    }
}
