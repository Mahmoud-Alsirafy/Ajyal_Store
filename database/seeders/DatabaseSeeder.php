<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Categorie;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Categorie::factory(10)->create();
        Store::factory(5)->create();
        Product::factory(50)->create();
        User::factory(5)->create();
        Admin::factory(5)->create();
    }
}
