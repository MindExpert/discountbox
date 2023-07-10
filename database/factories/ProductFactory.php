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
        //$status = [StatusEnum::IN_PROGRESS, StatusEnum::AWARDED, StatusEnum::CONCLUDED];
        $status = [StatusEnum::IN_PROGRESS];

        return [
            'user_id'       => 1,
            'serial'        => $this->faker->numerify('PR-######'),
            'name'          => $this->faker->catchPhrase(),
            'description'   => $this->faker->paragraphs(5, true),
            'review'        => $this->faker->paragraphs(5, true),
            'url'           => $this->faker->url(),
            'status'        => $status[rand(0, count($status)-1)],
            'highlighted'   => $this->faker->boolean(40),
            'show_on_home'  => $this->faker->boolean(80),
            'concluded_at'  => $this->faker->dateTimeBetween(now()->subDays(10), now()->addDays(30)),
        ];
    }
}
