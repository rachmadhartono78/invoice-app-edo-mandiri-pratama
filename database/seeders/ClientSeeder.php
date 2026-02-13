<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clients')->delete();
        
        DB::table('clients')->insert([
            [
                'id' => 1,
                'name' => 'Rachmad Hartono',
                'email' => 'rahmadhartono62@gmail.com',
                'phone' => '082282825606',
                'address' => 'JL. Kaswari No 83, Mancasan Lor, Condongcatur, Depok, Sleman, Yogyakarta',
                'company' => NULL,
                'notes' => NULL,
                'created_at' => '2026-02-12 15:22:16',
                'updated_at' => '2026-02-12 15:22:16',
            ],
            [
                'id' => 2,
                'name' => 'PT. Maju Jaya',
                'email' => 'info@majujaya.com',
                'phone' => '021-1234567',
                'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'company' => NULL,
                'notes' => NULL,
                'created_at' => '2026-02-12 15:23:40',
                'updated_at' => '2026-02-12 15:23:40',
            ],
            [
                'id' => 3,
                'name' => 'CV. Berkah Sentosa',
                'email' => 'berkah@sentosa.com',
                'phone' => '022-7654321',
                'address' => 'Jl. Gatot Subroto No. 45, Bandung',
                'company' => NULL,
                'notes' => NULL,
                'created_at' => '2026-02-12 15:23:40',
                'updated_at' => '2026-02-12 15:23:40',
            ],
            [
                'id' => 4,
                'name' => 'Toko ABC',
                'email' => NULL,
                'phone' => '031-9876543',
                'address' => 'Jl. Ahmad Yani No. 78, Surabaya',
                'company' => NULL,
                'notes' => NULL,
                'created_at' => '2026-02-12 15:23:40',
                'updated_at' => '2026-02-12 15:23:40',
            ],
            [
                'id' => 5,
                'name' => 'Agus',
                'email' => NULL,
                'phone' => NULL,
                'address' => NULL,
                'company' => NULL,
                'notes' => NULL,
                'created_at' => '2026-02-12 15:23:40',
                'updated_at' => '2026-02-12 15:23:40',
            ],
        ]);
    }
}
