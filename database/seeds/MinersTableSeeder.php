<?php

use App\Models\Miner;
use Illuminate\Database\Seeder;

class MinersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Miner::create([
            'miner_name' => 'm0',
            'available' => true,
            'current_mining_wallet_id' => 1,
            'farm_id' => 1,
            'api_token' => Token::Unique('miners', 'api_token', 40 ),
        ]);

        Miner::create([
            'miner_name' => 'm1',
            'available' => true,
            'current_mining_wallet_id' => 2,
            'farm_id' => 1,
            'api_token' => Token::Unique('miners', 'api_token', 40 ),
        ]);

        Miner::create([
            'miner_name' => 'm0',
            'available' => true,
            'current_mining_wallet_id' => 3,
            'farm_id' => 2,
            'api_token' => Token::Unique('miners', 'api_token', 40 ),
        ]);

        Miner::create([
            'miner_name' => 'm0',
            'available' => true,
            'current_mining_wallet_id' => 4,
            'farm_id' => 3,
            'api_token' => Token::Unique('miners', 'api_token', 40 ),
        ]);

        Miner::create([
            'miner_name' => 'm0',
            'available' => true,
            'current_mining_wallet_id' => 5,
            'farm_id' => 4,
            'api_token' => Token::Unique('miners', 'api_token', 40 ),
        ]);

        $this->command->info('Total Record -> '. Miner::all()->count());
    }
}
