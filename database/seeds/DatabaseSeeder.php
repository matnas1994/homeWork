<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->command->call('migrate:refresh');
        $this->call(UsersSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(WarehousesSeeder::class);
        $this->call(ProductWarehouseSeeder::class);
    }
}
