<?php

use App\Models\Coin;
use Illuminate\Database\Seeder;

class CoinsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coin::create([
            'coin_name' => 'Bitcoin',
            'coin_ticker' => 'BTC',
            'coin_algo' => 'sha256',
            'explorer_link' => 'https://blockchain.info/',
            'explorer_type' => 'btc',
            'available' => true,
        ]);

        Coin::create([
            'coin_name' => 'Ethereum',
            'coin_ticker' => 'ETH',
            'coin_algo' => 'ethash',
            'explorer_link' => 'https://etherscan.io/',
            'explorer_type' => 'eth',
            'available' => true,
        ]);

        Coin::create([
            'coin_name' => 'Bitcoin Cash',
            'coin_ticker' => 'BCH',
            'coin_algo' => 'sha256',
            'explorer_link' => 'https://blockdozer.com/',
            'explorer_type' => 'bch',
            'available' => true,
        ]);

        Coin::create([
            'coin_name' => 'Alqo',
            'coin_ticker' => 'ALQO',
            'coin_algo' => 'quark',
            'explorer_link' => 'https://explorer.alqo.org/',
            'explorer_type' => 'alqo',
            'available' => true,
        ]);

        Coin::create([
            'coin_name' => 'MasternodeXchange',
            'coin_ticker' => 'MNXCV2',
            'coin_algo' => 'x11',
            'isMineable' => false,
            'explorer_link' => 'http://mnxc.tk/',
            'explorer_type' => 'common',
            'available' => true,
        ]);

        Coin::create([
            'coin_name' => 'Mouse',
            'coin_ticker' => 'MOUSE',
            'coin_algo' => 'scrypt',
            'explorer_link' => 'http://explorer.mousecoin.ml/',
            'explorer_type' => 'common',
            'available' => true,
        ]);

        Coin::create([
            'coin_name' => 'TUNE',
            'coin_ticker' => 'TUN',
            'coin_algo' => 'neoscrypt',
            'explorer_link' => 'http://173.249.24.88:3001/',
            'explorer_type' => 'common',
            'available' => true,
        ]);

        Coin::create([
            'coin_name' => 'TINCOIN',
            'coin_ticker' => 'TIN',
            'coin_algo' => 'tribus',
            'explorer_link' => 'http://explorer.tincoinpay.com/',
            'explorer_type' => 'common',
            'available' => true,
        ]);

        Coin::create([
            'coin_name' => 'BitHold',
            'coin_ticker' => 'BHD',
            'coin_algo' => 'c11',
            'explorer_link' => 'http://bithold.lchain.cc/',
            'explorer_type' => 'common',
            'available' => true,
        ]);

        Coin::create([
            'coin_name' => 'Advance Protocol',
            'coin_ticker' => 'ADV',
            'coin_algo' => 'x11',
            'explorer_link' => 'https://explorer.advanceprotocol.net/',
            'explorer_type' => 'common',
            'available' => true,
        ]);

        Coin::create([
            'coin_name' => 'Rapture',
            'coin_ticker' => 'RAP',
            'coin_algo' => 'neoscrypt',
            'explorer_link' => 'http://explorer.our-rapture.com/',
            'explorer_type' => 'common',
            'available' => true,
        ]);

        Coin::create([
            'coin_name' => 'Beetle',
            'coin_ticker' => 'BEET',
            'coin_algo' => 'scrypt',
            'explorer_link' => 'http://explorer.beetlecoin.ninja:81/',
            'explorer_type' => 'common',
            'available' => true,
        ]);

        Coin::create([
            'coin_name' => 'Phobos',
            'coin_ticker' => 'PBS',
            'coin_algo' => 'lyra2z',
            'available' => true,
        ]);

        Coin::create([
            'coin_name' => 'LuxCore',
            'coin_ticker' => 'LUX',
            'coin_algo' => 'phi1612',
            'explorer_link' => 'https://explorer.luxcoin.xyz/',
            'explorer_type' => 'common',
            'available' => true,
        ]);

        Coin::create([
            'coin_name' => 'RACE',
            'coin_ticker' => 'RACE',
            'coin_algo' => 'lyra2v2',
            'explorer_link' => 'https://explorer.racecrypto.com/',
            'explorer_type' => 'common',
            'available' => true,
        ]);

        Coin::create([
            'coin_name' => 'Stipend',
            'coin_ticker' => 'SPD',
            'coin_algo' => 'c11',
            'explorer_link' => 'http://159.203.82.82:6001/',
            'explorer_type' => 'common',
            'available' => true,
        ]);

        Coin::create([
            'coin_name' => 'Curium',
            'coin_ticker' => 'CRU',
            'coin_algo' => 'x11',
            'explorer_link' => 'http://cru.altexplorer.co/',
            'explorer_type' => 'common',
            'available' => true,
        ]);

        Coin::create([
            'coin_name' => 'Folm',
            'coin_ticker' => 'FLM',
            'coin_algo' => 'phi1612',
            'explorer_link' => 'http://folm.blockxplorer.info/',
            'explorer_type' => 'common',
            'available' => true,
        ]);

        Coin::create([
            'coin_name' => 'Transend',
            'coin_ticker' => 'TSC',
            'coin_algo' => 'xevan',
            'explorer_link' => 'http://transend.blockxplorer.info/',
            'explorer_type' => 'common',
            'available' => true,
        ]);

        Coin::create([
            'coin_name' => 'TimeCoin',
            'coin_ticker' => 'TIMEC',
            'coin_algo' => 'skein',
            'available' => true,
        ]);

        Coin::create([
            'coin_name' => 'BANQ',
            'coin_ticker' => 'BANQ',
            'coin_algo' => 'neoscrypt',
            'available' => true,
        ]);

        $this->command->info('Total Record -> '. Coin::all()->count());
    }
}
