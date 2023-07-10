<?php

namespace Database\Seeders;

use App\Models\DiscountBox;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductDiscountBoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productCount = Product::count();

        if (0 === $productCount) {
            $this->command->info('No Products Found. Skipping assigning categories to books!');
            return;
        }

        $howManyMin = (int)$this->command->ask('Minimum products would you like on e Discount Box?', 6);
        $howManyMax = min((int)$this->command->ask('How many max products would you like on e Discount Box?', $productCount), $productCount);

        DiscountBox::all()->each(function(DiscountBox $discountBox) use($howManyMin, $howManyMax) {
            $take = random_int($howManyMin, $howManyMax);
            $products = Product::query()->inRandomOrder()->take($take)->get()->pluck('id');
            $discountBox->products()->sync($products);
        });
    }
}
