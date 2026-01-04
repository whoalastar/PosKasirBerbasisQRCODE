<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Makanan Utama', 'description' => 'Makanan utama seperti nasi, mie, dll'],
            ['name' => 'Minuman', 'description' => 'Berbagai macam minuman'],
            ['name' => 'Dessert', 'description' => 'Makanan penutup'],
            ['name' => 'Appetizer', 'description' => 'Makanan pembuka'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}