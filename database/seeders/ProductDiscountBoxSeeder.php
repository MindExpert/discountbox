<?php

namespace Database\Seeders;

use App\Models\DiscountBox;
use App\Models\Product;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductDiscountBoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws Exception
     */
    public function run(): void
    {
        $productCount = Product::count();

        //if products count is more than 20 max products on discount box
        if ($productCount > 20) {
            $productCount = 20;
        }

        if (0 === $productCount) {
            $this->command->info('No Products Found. Skipping assigning products to Discount Box!');
            return;
        }

        $howManyMin = (int)$this->command->ask('Minimum products would you like on Discount Box?', 6);
        $howManyMax = min((int)$this->command->ask('How many max products would you like on Discount Box?', $productCount), $productCount);

        DiscountBox::all()->each(function(DiscountBox $discountBox) use($howManyMin, $howManyMax) {
            $take = random_int($howManyMin, $howManyMax);
            $products = Product::query()->inRandomOrder()->take($take)->get()->pluck('id');
            $discountBox->products()->sync($products);
        });
    }
}
