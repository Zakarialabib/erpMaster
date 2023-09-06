<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    protected $model = Brand::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'              => $this->faker->company(),
            'slug'              => Str::slug($this->faker->company()),
            'description'       => $this->faker->realText(100),
            'image'             => $this->faker->imageUrl(400, 400),
            'meta_title '       => $this->faker->sentence(),
            'meta_description ' => $this->faker->sentence(),
            'origin '           => $this->faker->country(),
        ];
    }
}
