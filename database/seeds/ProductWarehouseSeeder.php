<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Warehouse;

class ProductWarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();
        $warehouses = Warehouse::all();
        $warehousesCount = $warehouses->count();
        $productsCount = $products->count();

        if (0 === $productsCount) {
            $this->command->info('No products found, skipping assigning products to warehouses');
        }

        if (0 === $warehousesCount) {
            $this->command->info('No warehouses found, skipping assigning products to warehouses');
        }

        $howManyMin = max((int)$this->command->ask('Minimum number of warehouses in which the product is?', 1), 1);
        $howManyMax = min((int)$this->command->ask('Maximum number of warehouses in which the product is?', $warehousesCount), $warehousesCount);

        $minStockLevel = (int)$this->command->ask('Minimum stock Level of product?', 1);
        $maxStockLevel = (int)max($this->command->ask('Maximum stock Level of product?', 100), $minStockLevel);

        $products->each(function (Product $product) use ($howManyMin, $howManyMax, $minStockLevel, $maxStockLevel, $warehouses) {
            $take = random_int($howManyMin, $howManyMax);
            $randomWarehouses = $warehouses->random($take)->pluck('id');
            $product->warehouses()->attach($randomWarehouses, ['stock_level' => random_int($minStockLevel, $maxStockLevel)]);
        });
    }
}
