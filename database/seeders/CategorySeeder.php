<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
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
            'Elektronik',
            'Ev Aletleri',
            'Moda',
            'Kişisel Bakım',
            'Spor Ekipmanları',
            'Oyuncak ve Hobiler',
            'Sağlık ve İyi Yaşam',
            'Gıda ve İçecek',
            'Mobilya ve Dekorasyon',
            'Kitaplar ve Eğitim'
        ];

        foreach ($categories as $category) {
            ProductCategory::query()->create(['name' => $category]);
        }
    }
}
