<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = Category::factory()->count(7)->create();

        foreach ($categories as $category) {
            Product::factory()->count(30)->create([
                'id_category' => $category->id,
            ]);
        }
        
        // User::factory(10)->create();

       // User::factory()->create([
         //   'name' => 'Test User',
           // 'email' => 'test@example.com',
        //]);
    }
}
