<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Category::create(['nama_kategori' => 'Fasilitas Publik']);
        \App\Models\Category::create(['nama_kategori' => 'Sanitasi']);
        \App\Models\Category::create(['nama_kategori' => 'Kesehatan']);
        \App\Models\Category::create(['nama_kategori' => 'Sosial']);
    }
}
