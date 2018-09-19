<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            CoinsTableSeeder::class,
            MarketsTableSeeder::class,
            PoolsTableSeeder::class,
            MonitorInfosTableSeeder::class,
            FarmsTableSeeder::class,
            MinersTableSeeder::class,
            WalletsTableSeeder::class,
            FarmUsersTableSeeder::class,
            MonitorsTableSeeder::class,
            SoftwaresTableSeeder::class,
            SoftwareUsagesTableSeeder::class,
            AuthorizationSeeder::class,
        ]);
    }
}
