<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Anotonio',
            'description' => 'mete goles',
            'descriptionLong' => 'con el barcelona',
            'price' => 9.5,
        ]);
    }
}
