<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departamentos')->insert([
            ['codigo' => '0001', 'designacao' => 'Administração', 'descricao' =>'Administração', 'status' => true],
            ['codigo' => '0001', 'designacao' => 'Gestão', 'descricao' =>'Gestão', 'status' => true],
            ['codigo' => '0001', 'designacao' => 'Vendas', 'descricao' =>'Vendas', 'status' => true],
        ]);
    }
}
