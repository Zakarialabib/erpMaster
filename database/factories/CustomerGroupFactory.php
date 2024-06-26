<?php

declare(strict_types=1);

namespace App\Factories;

use App\Models\CustomerGroup;

class CustomerGroupFactory extends \Illuminate\Database\Eloquent\Factories\Factory
{
    /**
     * The model the factory belongs to.
     *
     * @var string
     */
    protected $model = CustomerGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'       => $this->faker->word,
            'percentage' => $this->faker->numberBetween(1, 100),
            'status'     => true,
        ];
    }
}
