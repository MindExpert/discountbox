<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'user_id'       => 1,
            'serial'        => $this->faker->numerify('PR-######'),
            'name'          => $this->faker->catchPhrase(),
            'description'   => $this->faker->paragraphs(5, true),
            'review'        => $this->faker->paragraphs(5, true),
            'url'           => $this->faker->url(),
        ];
    }
}
