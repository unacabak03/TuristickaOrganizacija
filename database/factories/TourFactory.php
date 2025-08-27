<?php

namespace Database\Factories;

use App\Models\Tour;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tour::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(10),
            'description' => fake()->sentence(15),
            'location' => fake()->text(255),
            'price' => fake()->randomFloat(2, 0, 9999),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'max_participants' => fake()->randomNumber(),
        ];
    }
}
