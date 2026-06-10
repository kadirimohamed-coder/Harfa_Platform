<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'mohammed@harfa.ma'],
            [
                'name' => 'Mohammed Kadiri',
                'password' => Hash::make('mohammedAdmin1.2026'),
                'role' => 'admin',
                'phone' => '0774380553',
                'status' => 'active',
            ]
        );
        User::firstOrCreate(
            ['email' => 'yassin@harfa.ma'],
            [
                'name' => 'Yassin Boujeloul',
                'password' => Hash::make('yassinAdmin2.2026'),
                'role' => 'admin',
                'phone' => '0774380553',
                'status' => 'active',
            ]
        );

        // User::firstOrCreate(
        //     ['email' => 'admin2@harfa.ma'],
        //     [
        //         'name' => 'Admin Secondaire',
        //         'password' => Hash::make('password'),
        //         'role' => 'admin',
        //         'status' => 'active',
        //     ]
        // );
    }
}
