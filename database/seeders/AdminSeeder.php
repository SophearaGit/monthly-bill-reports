<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::insert(
            [
                [
                    'name' => 'admin',
                    'email' => 'admin@gmail.com',
                    'password' => bcrypt('12345678'),
                ],
                [
                    'name' => 'Ly Anita',
                    'email' => 'anita@gmail.com',
                    'password' => bcrypt('12345678'),
                ],
                [
                    'name' => 'Seth Sopheara',
                    'email' => 'sopheara@gmail.com',
                    'password' => bcrypt('12345678'),
                ],
            ]
        );
    }
}
