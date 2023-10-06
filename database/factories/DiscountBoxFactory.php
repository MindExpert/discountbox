<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use App\Models\DiscountBox;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DiscountBox>
 */
class DiscountBoxFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = [StatusEnum::IN_PROGRESS];

        $price = $this->faker->randomFloat(2, 5, 50);
        $discount = $this->faker->randomFloat(2, 0, $price);
        $total = $price - $discount;

        return [
            'user_id'       => 1,
            'product_id'    => Product::query()->inRandomOrder()->first()->id,
            'serial'        => $this->faker->numerify('DB-######'),
            'name'          => $this->faker->catchPhrase(),
            'price'         => $price,
            'discount'      => $discount,
            'total'         => $total,
            'max_discount_percentage' => $this->faker->randomFloat(2, 0, 90),
            'expires_at'    => $this->faker->dateTimeBetween(now()->addDays(10), now()->addMonths(2)),
            'credits'       => $this->faker->randomNumber(2),
            'status'        => $status[rand(0, count($status)-1)],
            'highlighted'   => $this->faker->boolean(44),
            'show_on_home'  => $this->faker->boolean(85),
        ];
    }
}
