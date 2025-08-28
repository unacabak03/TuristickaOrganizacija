<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tour;
use Illuminate\Database\Seeder;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tours = Tour::factory()->count(5)->create();

        $categoryIds = Category::pluck('id');

        $tours->each(function (Tour $tour) use ($categoryIds) {
            $tour->categories()->attach(
                $categoryIds->random(rand(1, 3))->all()
            );
        });
    }
}
