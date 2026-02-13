<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();
        
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Rachmad Hartono',
                'email' => 'rahmadhartono78@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$OcK7U9XsjxRQK7G1HAYUDOdAv7ok82xtWbYgSrqysOv30Wig47tS2',
                'remember_token' => NULL,
                'created_at' => '2026-02-11 18:32:18',
                'updated_at' => '2026-02-11 18:32:18',
            ],
            [
                'id' => 2,
                'name' => 'rachmad hartono',
                'email' => 'rahmadhartono62@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$YTHrilWaBcsrlExOOSV6OOeQ1VGdKhtAvYNbKzH6oZ8Il0JVgBzJe',
                'remember_token' => NULL,
                'created_at' => '2026-02-12 07:12:15',
                'updated_at' => '2026-02-12 07:12:15',
            ],
        ]);
    }
}
