<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userCount = (int)$this->command->ask('How many users would you like', random_int(1, 9));

        factory(App\User::class)->state('demo')->create();
        factory(App\User::class, $userCount)->create();

        $this->command->call('passport:client', ['--personal' => true]);
    }
}
