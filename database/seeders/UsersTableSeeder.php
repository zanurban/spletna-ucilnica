<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('Users')->insert([
            'id' => Str::uuid(),
            'first_name' => 'Maj',
            'last_name' => 'Zabukovnik',
            'email' => 'zabukm@example.com',
            'username' => 'zabukm',
            'password' => Hash::make('aspiria00'),
            'role' => 'adm',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('Users')->insert([
            'id' => Str::uuid(),
            'first_name' => 'Žan',
            'last_name' => 'Škorja',
            'email' => 'skorja@example.com',
            'username' => 'skorjaz',
            'password' => Hash::make('aspiria00'),
            'role' => 'tch',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('Users')->insert([
            'id' => Str::uuid(),
            'first_name' => 'Lan',
            'last_name' => 'Stokavnik',
            'email' => 'stokavnik@example.com',
            'username' => 'stokavnikl',
            'password' => Hash::make('aspiria00'),
            'role' => 'usr',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::factory()->count(100)->create();
    }
}
