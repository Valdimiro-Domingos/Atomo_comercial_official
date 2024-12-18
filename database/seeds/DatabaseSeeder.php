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
        //$this->call(EnderecoTableSeeder::class);
        // $this->call(DepartamentoTableSeeder::class);
        $this->call(UserTableSeeder::class);
        // $this->call(RegrasTableSeeder::class);
    }
}
