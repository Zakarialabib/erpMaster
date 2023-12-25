<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Blog;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'            => $this->faker->sentence,
            'slug'             => $this->faker->slug,
            'description'      => $this->faker->paragraph,
            'image'            => null, // uploadImage('images/blogs', '640', '480'),
            'meta_title'       => $this->faker->sentence,
            'meta_description' => $this->faker->paragraph(1),
            'language_id'      => 1,
            'featured'         => true,
            'status'           => true,
        ];
    }
}
