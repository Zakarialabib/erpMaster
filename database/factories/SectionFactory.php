<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pageType = $this->faker->randomElement(['home', 'about', 'contact', 'products', 'privacy', 'terms', 'catalog']);

        return [
            'title'          => $pageType,
            'featured_title' => 'Tahe Cosmetics',
            'subtitle'       => 'Tahe Cosmetics',
            'image'          => uploadImage('images/sections', '640', '480'),
            'description'    => json_encode(['text' => $this->faker->paragraph]),
            'image'          => $this->faker->imageUrl(),
            'type'           => $pageType,
            'status'         => $this->faker->boolean ? 1 : 0,
            'label'          => 'Tahe Cosmetics',
            'link'           => 'https://Tahe-Cosmetics.com/',
            'bg_color'       => '#00000',
            'text_color'     => '#ffffff',
        ];
    }
}
