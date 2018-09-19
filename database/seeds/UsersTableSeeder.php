<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->TestData();

        //create 10 dummy user
        factory(User::class, 10)->create();

        $this->command->info('Total Record -> ' . User::all()->count());
    }

    private function TestData()
    {
        User::create([
            'name' => 'demo1',
            'email' => 'demo1@demo.com',
            'password' => 'demo123',
            'remember_token' => str_random(10),
            'available' => true,
        ]);

        User::create([
            'name' => 'demo2',
            'email' => 'demo2@demo.com',
            'password' => 'demo123',
            'remember_token' => str_random(10),
            'available' => true,
        ]);

        User::create([
            'name' => 'demo3',
            'email' => 'demo3@demo.com',
            'password' => 'demo123',
            'remember_token' => str_random(10),
            'available' => true,
        ]);
    }
}
