<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)-
        \DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'a@tekito.com',
                'email_verified_at' => now(),
                'password' => \Hash::make('a@tekito.com'),
                'admin' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],[
                'name' => 'test',
                'email' => 'test@example.com',
                'email_verified_at' => now(),
                'password' => \Hash::make('test'),
                'admin' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
