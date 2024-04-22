<?php

namespace Database\Factories;

use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'content' => fake()->paragraphs(3, true),
            'categorie_id' =>  Categorie::all()->random()->id,
            'date_start' => fake()->dateTimeBetween('-1 year', '-4 months')->format('Y-m-d'),
            'date_expiration' => fake()->dateTimeBetween('now', '+1 months')->format('Y-m-d'),
        ];
    }
}
