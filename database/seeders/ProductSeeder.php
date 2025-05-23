<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Laptop', 'price' => 75000],
            ['name' => 'Mouse', 'price' => 500],
            ['name' => 'Keyboard', 'price' => 1200],
            ['name' => 'Monitor', 'price' => 15000],
            ['name' => 'Printer', 'price' => 8500],
            ['name' => 'Scanner', 'price' => 6000],
            ['name' => 'Webcam', 'price' => 2500],
            ['name' => 'Speaker', 'price' => 1800],
            ['name' => 'Router', 'price' => 3200],
            ['name' => 'External Hard Drive', 'price' => 10500],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']], 
                ['price' => $product['price']] 
            );
        }
    }
}
