<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'electronicos',
                'description' => 'Articulos electronicos'
            ],
                        [
                'name' => 'Ropa',
                'description' => 'Articulos de ropa'
            ],
                        [
                'name' => 'juguetes',
                'description' => 'Articulos de juguete'
            ],
        ];

        foreach ($categories as $category){
            Category::create($category);
        }
    }
}
