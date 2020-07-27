<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productCount = (int)$this->command->ask('How many products would you like', random_int(100, 900));
        factory(Product::class, $productCount)->create();
    }
}
