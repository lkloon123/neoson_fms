<?php

use App\Models\Farm;
use Illuminate\Database\Seeder;

class FarmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Farm::create([
            'farm_name' => 'testFarm1',
            'available' => true,
            'pool_id' => 19,
            'coin_id' => 19,
        ]);

        Farm::create([
            'farm_name' => 'testFarm2',
            'available' => true,
            'pool_id' => 12,
            'coin_id' => 12,
        ]);

        Farm::create([
            'farm_name' => 'testFarm3',
            'available' => true,
            'pool_id' => 19,
            'coin_id' => 14,
        ]);

        Farm::create([
            'farm_name' => 'testFarm4',
            'available' => true,
            'pool_id' => 19,
            'coin_id' => 13,
        ]);

        $this->command->info('Total Record -> '. Farm::all()->count());
    }
}
