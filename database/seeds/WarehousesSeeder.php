<?php

use Illuminate\Database\Seeder;
use App\Warehouse;

class WarehousesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $warehouseCount = (int)$this->command->ask('How many warehouses would you like?', random_int(5, 10));
        factory(Warehouse::class, $warehouseCount)->create();
    }
}
