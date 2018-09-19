<?php

use App\Models\SoftwareUsage;
use Illuminate\Database\Seeder;

class SoftwareUsagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->cuda9();

        $this->command->info('Total Record -> ' . SoftwareUsage::all()->count());
    }

    private function cuda9(){
        SoftwareUsage::create([
            'algo' => 'phi1612',
            'algo_setup_name' => 'phi',
            'software_id' => 6,
        ]);

        SoftwareUsage::create([
            'algo' => 'neoscrypt',
            'algo_setup_name' => 'neoscrypt',
            'software_id' => 3,
        ]);

        SoftwareUsage::create([
            'algo' => 'nist5',
            'algo_setup_name' => 'nist5',
            'software_id' => 3,
        ]);

        SoftwareUsage::create([
            'algo' => 'fresh',
            'algo_setup_name' => 'fresh',
            'software_id' => 3,
        ]);

        SoftwareUsage::create([
            'algo' => 'c11',
            'algo_setup_name' => 'c11',
            'software_id' => 3,
        ]);

        SoftwareUsage::create([
            'algo' => 'lyra2v2',
            'algo_setup_name' => 'lyra2v2',
            'software_id' => 3,
        ]);

        SoftwareUsage::create([
            'algo' => 'lyra2z',
            'algo_setup_name' => 'lyra2z',
            'software_id' => 2,
        ]);

        SoftwareUsage::create([
            'algo' => 'tribus',
            'algo_setup_name' => 'tribus',
            'software_id' => 2,
        ]);

        SoftwareUsage::create([
            'algo' => 'skein',
            'algo_setup_name' => 'skein',
            'software_id' => 3,
        ]);

        SoftwareUsage::create([
            'algo' => 'skunk',
            'algo_setup_name' => 'skunk',
            'software_id' => 7,
        ]);

        SoftwareUsage::create([
            'algo' => 'xevan',
            'algo_setup_name' => 'xevan',
            'software_id' => 8,
        ]);
    }
}
