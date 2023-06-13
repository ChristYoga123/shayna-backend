<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "Admin Shayna",
            "email" => "adminshaya@gmail.com",
            "password" => bcrypt("password"),
            "role" => "Admin"
        ]);
    }
}