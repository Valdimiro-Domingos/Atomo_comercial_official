<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnderecoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('enderecos')
            ->insert([
                [
                    'endereco1' => 'endereco 1 teste',
                    'endereco2' => 'endereco 2 teste',
                    'endereco3' => 'endereco 3 teste',
                    'email' => 'email teste',
                    'telefone1' => 'telefone 1 teste',
                    'telefone2' => 'telefone 2 teste',
                    'telefone3' => 'telefone 3 teste',
                    'facebook' => 'facebook teste',
                    'youtube' => 'youtube teste',
                    'linkedin' => 'linkedin teste',
                ]
            ]);
    }
}
