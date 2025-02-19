<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'rozikhin',
            'email' => 'rozikhinkhoirur@gmail.com',
            'password' => Hash::make('rozikhin-1234'), // Default password
        ]);

        User::create([
            'name' => 'hudi',
            'email' => 'hudi@gmail.com',
            'password' => Hash::make('hudi-1234'),
        ]);
    }
}
