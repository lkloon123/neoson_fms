<?php

use App\Models\Wallet;
use Illuminate\Database\Seeder;

class WalletsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Wallet::create([
            'wallet_address' => 'TTSgFdURZMq8i1duxafbsaKsJLN4rXHZRc',
            'available' => true,
            'miner_id' => 1,
            'coin_id' => 19,
        ]);

        Wallet::create([
            'wallet_address' => 'TVbxzeZm3tepzpMv88vQyxYLv8tJdLMFLk',
            'available' => true,
            'miner_id' => 1,
            'coin_id' => 19,
        ]);

        Wallet::create([
            'wallet_address' => 'TWeoAfCuQKjsTyyYkLy5nxTU7yVm9Jp2fQ',
            'available' => true,
            'miner_id' => 2,
            'coin_id' => 19,
        ]);

        Wallet::create([
            'wallet_address' => 'TSaU57DBrJhRozZaeQ9nTP2NPf5GGLHgjY',
            'available' => true,
            'miner_id' => 3,
            'coin_id' => 19,
        ]);

        Wallet::create([
            'wallet_address' => 'TQXR1KVhyGYUfMVNvS6vtJatqqUo92NHa7',
            'available' => true,
            'miner_id' => 4,
            'coin_id' => 19,
        ]);

        Wallet::create([
            'wallet_address' => 'FgqHjbwZdBpgs7XEzjVgiYihwWSvP1Ed7o',
            'available' => true,
            'miner_id' => 1,
            'coin_id' => 18,
        ]);

        Wallet::create([
            'wallet_address' => 'FZ7tqb3u3qwcteYZFJm3hdYSunfDFMqAHF',
            'available' => true,
            'miner_id' => 2,
            'coin_id' => 18,
        ]);

        $this->command->info('Total Record -> '. Wallet::all()->count());
    }
}
