<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'        => $this->faker->company(),
            'code'        => Str::random(5),
            'description' => $this->faker->sentence(),
            'slug'        => $this->faker->slug(),
            'image'       => $this->faker->image(),
            'status'      => $this->faker->randomElement([0, 1]),
        ];
    }
}
