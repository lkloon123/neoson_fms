<?php

use App\Models\FarmUser;
use Illuminate\Database\Seeder;

class FarmUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FarmUser::create([
            'isFarmOwner' => true,
            'farm_id' => 1,
            'user_id' => 1,
        ]);

        FarmUser::create([
            'farm_id' => 2,
            'user_id' => 1,
        ]);

        $this->command->info('Total Record -> '. FarmUser::all()->count());
    }
}
