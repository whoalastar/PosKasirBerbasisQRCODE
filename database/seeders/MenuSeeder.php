<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            ['name' => 'Nasi Goreng Spesial', 'category_id' => 1, 'price' => 25000, 'stock' => 50],
            ['name' => 'Mie Ayam', 'category_id' => 1, 'price' => 20000, 'stock' => 30],
            ['name' => 'Es Teh Manis', 'category_id' => 2, 'price' => 5000, 'stock' => 100],
            ['name' => 'Jus Jeruk', 'category_id' => 2, 'price' => 15000, 'stock' => 50],
            ['name' => 'Es Cream Vanilla', 'category_id' => 3, 'price' => 12000, 'stock' => 20],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}