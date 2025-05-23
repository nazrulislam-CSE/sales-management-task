<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Admin user
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );

        // customers
        $customers = [
            ['name' => 'Nazrul Islam', 'email' => 'nsuzon02@gmail.com'],
            ['name' => 'Rahim Uddin', 'email' => 'rahim@gmail.com'],
            ['name' => 'Karim Hossain', 'email' => 'karim@gmail.com'],
            ['name' => 'Shakil Ahmed', 'email' => 'shakil@gmail.com'],
            ['name' => 'Sumaiya Akter', 'email' => 'sumaiya@gmail.com'],
            ['name' => 'Jannatul Ferdous', 'email' => 'jannatul@gmail.com'],
            ['name' => 'Rasel Miah', 'email' => 'rasel@gmail.com'],
            ['name' => 'Fahim Chowdhury', 'email' => 'fahim@gmail.com'],
            ['name' => 'Tania Sultana', 'email' => 'tania@gmail.com'],
            ['name' => 'Mamunur Rashid', 'email' => 'mamun@gmail.com'],
        ];

        foreach ($customers as $customer) {
            User::updateOrCreate(
                ['email' => $customer['email']],
                [
                    'name' => $customer['name'],
                    'password' => Hash::make('12345678'),
                    'email_verified_at' => now(),
                ]
            );
        }
    }

}
