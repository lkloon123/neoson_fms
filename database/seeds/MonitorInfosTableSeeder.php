<?php

use App\Models\MonitorInfo;
use Illuminate\Database\Seeder;

class MonitorInfosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MonitorInfo::create([
            'wallet_address' => 'Adm1MBka9GLihMKt162i5utFfDh3FTXvPM',
            'coin_id' => 4,
            'coin_balance' => 259.16484361,
            'available' => true,
        ]);

        MonitorInfo::create([
            'wallet_address' => 'MQPo8yCXGfaqUwkDpZ89cv6v7qkabe5j7F',
            'coin_id' => 6,
            'coin_balance' => 2281.50082865,
            'available' => true,
        ]);

        MonitorInfo::create([
            'wallet_address' => 'TCsYphuzsBuqBw8QTm1XSDScSz6c9A727J',
            'coin_id' => 7,
            'coin_balance' => 34.79954765,
            'available' => true,
        ]);

        MonitorInfo::create([
            'wallet_address' => 'tJRjHjP2Di2SKCcXwpv9KNwfsujncQunV3',
            'coin_id' => 8,
            'coin_balance' => 38.65159244,
            'available' => true,
        ]);

        MonitorInfo::create([
            'wallet_address' => 'ALSXUimyMwusg5ErJ4xzemMw4TKwuUmj1R',
            'coin_id' => 10,
            'coin_balance' => 73.5539401,
            'available' => true,
        ]);

        MonitorInfo::create([
            'wallet_address' => 'RVauovTw1gVp1RxLmiF2Tge5MEKGwwnqpH',
            'coin_id' => 11,
            'coin_balance' => 0.12244536,
            'available' => true,
        ]);

        $this->command->info('Total Record -> ' . MonitorInfo::all()->count());
    }
}
