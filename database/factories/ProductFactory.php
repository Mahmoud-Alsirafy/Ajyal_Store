<?php

namespace Database\Factories;

use App\Models\Categorie;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(15),
            'image' => $this->faker->imageUrl(640, 480, 'products'),
            'status' => $this->faker->randomElement(['active', 'draft', 'archived']),
            'price' => $this->faker->randomFloat(1, 1, 499),
            'compare_price' => $this->faker->randomFloat(1, 500, 999),
            'store_id' => Store::inRandomOrder()->first()->id,
            'category_id' => Categorie::inRandomOrder()->first()->id,
            'featured' => $this->faker->numberBetween(0, 1),
            'stock' => $this->faker->numberBetween(50, 100),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}