<?php

use App\Models\Pool;
use Illuminate\Database\Seeder;

class PoolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->yiimp();

        $this->oep();

        $this->mpos();

        $this->command->info('Total Record -> ' . Pool::all()->count());
    }

    private function yiimp()
    {
        Pool::create([
            'pool_name' => 'bsod',
            'pool_stratum' => 'pool.bsod.pw',
            'pool_api' => 'http://api.bsod.pw/api/',
            'pool_url' => 'http://bsod.pw/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'arcpool',
            'pool_stratum' => 'eu1.arcpool.com',
            'pool_api' => 'https://arcpool.com/api/',
            'pool_url' => 'https://arcpool.com/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'altminer',
            'pool_stratum' => 'eu1.altminer.net',
            'pool_api' => 'https://altminer.net/api/',
            'pool_url' => 'https://altminer.net/',
        ]);

        Pool::create([
            'pool_name' => 'hashfaster',
            'pool_stratum' => 'hashfaster.com',
            'pool_api' => 'https://hashfaster.com/api/',
            'pool_url' => 'https://hashfaster.com/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'protopool',
            'pool_stratum' => 'eu1.protopool.net',
            'pool_api' => 'https://protopool.net/api/',
            'pool_url' => 'https://protopool.net/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'zergpool',
            'pool_stratum' => 'mine.zergpool.com',
            'pool_api' => 'http://api.zergpool.com:8080/api/',
            'pool_url' => 'http://zergpool.com/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'clutzykid',
            'pool_stratum' => 'clutzykid.com',
            'pool_api' => 'https://clutzykid.com/api/',
            'pool_url' => 'https://clutzykid.com/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'blockmunch',
            'pool_stratum' => 'blockmunch.club',
            'pool_api' => 'http://blockmunch.club/api/',
            'pool_url' => 'http://blockmunch.club/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'miningpool.shop',
            'pool_stratum' => 'asia.miningpool.shop',
            'pool_api' => 'http://aws.miningpool.shop/api/',
            'pool_url' => 'http://miningpool.shop/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'friends-master',
            'pool_stratum' => 'pool.friends-master.net',
            'pool_api' => 'http://pool.friends-master.net/api/',
            'pool_url' => 'http://pool.friends-master.net/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'pooldaddy',
            'pool_stratum' => 'pooldaddy.ws',
            'pool_api' => 'https://pooldaddy.ws/api/',
            'pool_url' => 'https://pooldaddy.ws/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'masterhash',
            'pool_stratum' => 'yiimp.masterhash.us',
            'pool_api' => 'https://yiimp.masterhash.us/api/',
            'pool_url' => 'https://yiimp.masterhash.us/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'neopool',
            'pool_stratum' => 'neopool.net',
            'pool_api' => 'http://neopool.net/api/',
            'pool_url' => 'http://neopool.net/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'coinminers',
            'pool_stratum' => 'stratum-eu.coin-miners.info',
            'pool_api' => 'https://pool.coin-miners.info/api/',
            'pool_url' => 'https://coin-miners.info/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'tinypool',
            'pool_stratum' => 'pool.tiny-pool.com',
            'pool_api' => 'https://tiny-pool.com/api/',
            'pool_url' => 'https://tiny-pool.com/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'poolofd32th',
            'pool_stratum' => 'yiimp.poolofd32th.club',
            'pool_api' => 'http://yiimp.poolofd32th.club/api/',
            'pool_url' => 'http://yiimp.poolofd32th.club/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'gos.cx',
            'pool_stratum' => 'stratum.gos.cx',
            'pool_api' => 'https://www.gos.cx/api/',
            'pool_url' => 'https://www.gos.cx/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'dpool.io',
            'pool_stratum' => 'pool.minertopia.org',
            'pool_api' => 'https://dpool.io/api/',
            'pool_url' => 'https://dpool.io/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'transend-official-pool',
            'pool_stratum' => 'pool.transendcoin.com',
            'pool_api' => 'https://pool.transendcoin.com/api/',
            'pool_url' => 'https://pool.transendcoin.com/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'hash4life',
            'pool_stratum' => 'hash4.life',
            'pool_api' => 'https://hash4.life/api/',
            'pool_url' => 'https://hash4.life/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'saltpool',
            'pool_stratum' => 'saltpool.net',
            'pool_api' => 'https://saltpool.net/api/',
            'pool_url' => 'https://saltpool.net/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'hashpool-eu',
            'pool_stratum' => 'pool.hashpool.eu',
            'pool_api' => 'https://hashpool.eu/api/',
            'pool_url' => 'https://hashpool.eu/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'KWCHmining',
            'pool_stratum' => 'kwchmining.com',
            'pool_api' => 'http://kwchmining.com/api/',
            'pool_url' => 'http://kwchmining.com/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'poolr',
            'pool_stratum' => 'poolr.io',
            'pool_api' => 'https://poolr.io/api/',
            'pool_url' => 'https://poolr.io/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'the-pool-wizard',
            'pool_stratum' => 'saramandaia.top',
            'pool_api' => 'https://saramandaia.top/api/',
            'pool_url' => 'https://saramandaia.top/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'impulsemine',
            'pool_stratum' => 'impulsemine.xyz',
            'pool_api' => 'http://impulsemine.xyz/api/',
            'pool_url' => 'http://impulsemine.xyz/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'doufen',
            'pool_stratum' => 'doufen.com',
            'pool_api' => 'http://doufen.com/api/',
            'pool_url' => 'http://www.doufen.com/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'minpool',
            'pool_stratum' => 'minpool.net',
            'pool_api' => 'http://minpool.net/api/',
            'pool_url' => 'http://minpool.net/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'nicepool',
            'pool_stratum' => 'nicepool.me',
            'pool_api' => 'http://nicepool.me/api/',
            'pool_url' => 'http://nicepool.me/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'fatpanda',
            'pool_stratum' => 'yiimp.fatpanda.club',
            'pool_api' => 'http://pool.fatpanda.club/api/',
            'pool_url' => 'http://pool.fatpand.club/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'angry-pool',
            'pool_stratum' => 'angrypool.com',
            'pool_api' => 'http://angrypool.com/api/',
            'pool_url' => 'http://angrypool.com/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'mad-pool',
            'pool_stratum' => 'madpool.xy',
            'pool_api' => 'https://madpool.xyz/api/',
            'pool_url' => 'https://madpool.xyz/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'cryptopros',
            'pool_stratum' => 'pool.cryptopros.us',
            'pool_api' => 'https://pool.cryptopros.us/api/',
            'pool_url' => 'https://pool.cryptopros.us/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'zate',
            'pool_stratum' => 'zate.ddns.net',
            'pool_api' => 'http://zate.ddns.net/api/',
            'pool_url' => 'http://zate.ddns.net/',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'cryptorush',
            'pool_stratum' => 'cryptorushmining.com',
            'pool_api' => 'http://cryptorushmining.com/api/',
            'pool_url' => 'http://cryptorushmining.com/',
            'available' => true,
        ]);
    }

    private function oep()
    {
        Pool::create([
            'pool_name' => 'ubiq_minerpool',
            'pool_stratum' => 'lb.geo.ubiqpool.org',
            'pool_api' => 'http://ubiq.minerpool.net/api/',
            'pool_url' => 'http://ubiq.minerpool.net',
            'type' => 'oep',
            'ticker' => 'UBIQ',
            'algo' => 'ethash',
            'port' => '8001',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'dbix_poolsexy',
            'pool_stratum' => 'dbix.pool.sexy',
            'pool_api' => 'http://dbix.pool.sexy/api/v2/',
            'pool_url' => 'http://dbix.pool.sexy',
            'type' => 'oep',
            'ticker' => 'DBIX',
            'algo' => 'ethash',
            'port' => '10032',
            'available' => true,
        ]);
    }

    private function mpos()
    {
        Pool::create([
            'pool_name' => 'race_suprnova',
            'pool_stratum' => 'race.suprnova.cc',
            'pool_api' => 'https://race.suprnova.cc/index.php?page=api&action=',
            'pool_url' => 'https://race.suprnova.cc',
            'type' => 'mpos',
            'ticker' => 'RACE',
            'algo' => 'lyra2v2',
            'port' => '5650',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'btg_suprnova',
            'pool_stratum' => 'btg.suprnova.cc',
            'pool_api' => 'https://btg.suprnova.cc/index.php?page=api&action=',
            'pool_url' => 'https://btg.suprnova.cc/',
            'type' => 'mpos',
            'ticker' => 'BTG',
            'algo' => 'equihash',
            'port' => '8816',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'lcc_suprnova',
            'pool_stratum' => 'lcc.suprnova.cc',
            'pool_api' => 'https://lcc.suprnova.cc/index.php?page=api&action=',
            'pool_url' => 'https://lcc.suprnova.cc/',
            'type' => 'mpos',
            'ticker' => 'LCC',
            'algo' => 'sha256',
            'port' => '6868',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'bci_suprnova',
            'pool_stratum' => 'bci.suprnova.cc',
            'pool_api' => 'https://bci.suprnova.cc/index.php?page=api&action=',
            'pool_url' => 'https://bci.suprnova.cc/',
            'type' => 'mpos',
            'ticker' => 'BCI',
            'algo' => 'equihash',
            'port' => '8166',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'xvg-lyra_suprnova',
            'pool_stratum' => 'xvg-lyra.suprnova.cc',
            'pool_api' => 'https://xvg-lyra.suprnova.cc/index.php?page=api&action=',
            'pool_url' => 'https://xvg-lyra.suprnova.cc/',
            'type' => 'mpos',
            'ticker' => 'XVG',
            'algo' => 'lyra2v2',
            'port' => '2595',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'xvg-x17_suprnova',
            'pool_stratum' => 'xvg-x17.suprnova.cc',
            'pool_api' => 'https://xvg-x17.suprnova.cc/index.php?page=api&action=',
            'pool_url' => 'https://xvg-x17.suprnova.cc/',
            'type' => 'mpos',
            'ticker' => 'XVG',
            'algo' => 'x17',
            'port' => '7477',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'xvg-mg_suprnova',
            'pool_stratum' => 'xvg-mg.suprnova.cc',
            'pool_api' => 'https://xvg-mg.suprnova.cc/index.php?page=api&action=',
            'pool_url' => 'https://xvg-mg.suprnova.cc/',
            'type' => 'mpos',
            'ticker' => 'XVG',
            'algo' => 'myr-groestl',
            'port' => '7722',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'roi_suprnova',
            'pool_stratum' => 'roi.suprnova.cc',
            'pool_api' => 'https://roi.suprnova.cc/index.php?page=api&action=',
            'pool_url' => 'https://roi.suprnova.cc/',
            'type' => 'mpos',
            'ticker' => 'ROI',
            'algo' => 'hodl',
            'port' => '4699',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'zero_suprnova',
            'pool_stratum' => 'zero.suprnova.cc',
            'pool_api' => 'https://zero.suprnova.cc/index.php?page=api&action=',
            'pool_url' => 'https://zero.suprnova.cc/',
            'type' => 'mpos',
            'ticker' => 'ZERO',
            'algo' => 'equihash-192,7',
            'port' => '6568',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'btcp_suprnova',
            'pool_stratum' => 'btcp.suprnova.cc',
            'pool_api' => 'https://btcp.suprnova.cc/index.php?page=api&action=',
            'pool_url' => 'https://btcp.suprnova.cc/',
            'type' => 'mpos',
            'ticker' => 'BTCP',
            'algo' => 'equihash',
            'port' => '6822',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'wavi_suprnova',
            'pool_stratum' => 'wavi.suprnova.cc',
            'pool_api' => 'https://wavi.suprnova.cc/index.php?page=api&action=',
            'pool_url' => 'https://wavi.suprnova.cc/',
            'type' => 'mpos',
            'ticker' => 'WAVI',
            'algo' => 'yescrypt32',
            'port' => '6762',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'rvn_suprnova',
            'pool_stratum' => 'rvn.suprnova.cc',
            'pool_api' => 'https://rvn.suprnova.cc/index.php?page=api&action=',
            'pool_url' => 'https://rvn.suprnova.cc/',
            'type' => 'mpos',
            'ticker' => 'RVN',
            'algo' => 'x16r',
            'port' => '6667',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'zcl_suprnova',
            'pool_stratum' => 'zcl.suprnova.cc',
            'pool_api' => 'https://zcl.suprnova.cc/index.php?page=api&action=',
            'pool_url' => 'https://zcl.suprnova.cc/',
            'type' => 'mpos',
            'ticker' => 'ZCL',
            'algo' => 'equihash',
            'port' => '4044',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'zen_suprnova',
            'pool_stratum' => 'zen.suprnova.cc',
            'pool_api' => 'https://zen.suprnova.cc/index.php?page=api&action=',
            'pool_url' => 'https://zen.suprnova.cc/',
            'type' => 'mpos',
            'ticker' => 'ZEN',
            'algo' => 'equihash',
            'port' => '3618',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'zec_suprnova',
            'pool_stratum' => 'zec.suprnova.cc',
            'pool_api' => 'https://zec.suprnova.cc/index.php?page=api&action=',
            'pool_url' => 'https://zec.suprnova.cc/',
            'type' => 'mpos',
            'ticker' => 'ZEC',
            'algo' => 'equihash',
            'port' => '2142',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'dash_suprnova',
            'pool_stratum' => 'dash80.suprnova.cc',
            'pool_api' => 'https://dash.suprnova.cc/index.php?page=api&action=',
            'pool_url' => 'https://dash.suprnova.cc/',
            'type' => 'mpos',
            'ticker' => 'DASH',
            'algo' => 'x11',
            'port' => '80',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'lbry_suprnova',
            'pool_stratum' => 'lbry.suprnova.cc',
            'pool_api' => 'https://lbry.suprnova.cc/index.php?page=api&action=',
            'pool_url' => 'https://lbry.suprnova.cc/',
            'type' => 'mpos',
            'ticker' => 'LBRY',
            'algo' => 'lbry',
            'port' => '6256',
            'available' => true,
        ]);

        Pool::create([
            'pool_name' => 'dcr_suprnova',
            'pool_stratum' => 'dcr.suprnova.cc',
            'pool_api' => 'https://dcr.suprnova.cc/index.php?page=api&action=',
            'pool_url' => 'https://dcr.suprnova.cc/',
            'type' => 'mpos',
            'ticker' => 'DCR',
            'algo' => 'blake256',
            'port' => '3252',
            'available' => true,
        ]);
    }
}
