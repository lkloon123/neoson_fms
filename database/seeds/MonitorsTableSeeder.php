<?php

use App\Models\Monitor;
use Illuminate\Database\Seeder;

class MonitorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Monitor::create([
            'monitor_info_id' => 1,
            'user_id' => 1,
        ]);

        Monitor::create([
            'monitor_info_id' => 2,
            'user_id' => 1,
        ]);

        Monitor::create([
            'monitor_info_id' => 3,
            'user_id' => 1,
        ]);

        Monitor::create([
            'monitor_info_id' => 4,
            'user_id' => 1,
        ]);

        Monitor::create([
            'monitor_info_id' => 5,
            'user_id' => 1,
        ]);

        Monitor::create([
            'monitor_info_id' => 6,
            'user_id' => 1,
        ]);

        $this->command->info('Total Record -> ' . Monitor::all()->count());
    }
}
