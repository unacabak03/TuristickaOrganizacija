<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rating'  => $this->faker->numberBetween(1,5),
            'comment' => $this->faker->sentence(8),
            'user_id' => \App\Models\User::factory(),
            'tour_id' => \App\Models\Tour::factory(),
        ];
    }
}
