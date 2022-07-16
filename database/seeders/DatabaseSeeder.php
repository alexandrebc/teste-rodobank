<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Giaffone',
            'email' => 'felipe.giaffone@gmail.com',
            'password' => bcrypt('password'),
        ]);

        \App\Models\User::factory(10)->create();
        \App\Models\Shipping::factory(10)->create();
        \App\Models\Driver::factory(10)->create();
        \App\Models\Truck::factory(20)->create();
        \App\Models\Contract::factory(10)->create();
    }
}
