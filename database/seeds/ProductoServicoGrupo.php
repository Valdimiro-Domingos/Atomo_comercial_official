<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoServicoGrupo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('producto_servico_grupos')
            ->insert([
                ['nome' => 'ALIMENTOS'],
                ['nome' => 'HIGIÉNE'],
                ['nome' => 'VESTUARIO'],
                ['nome' => 'ELETRODOMESTICO'],
                ['nome' => 'ELETRONICO'],
                ['nome' => 'MOBILIARIO'],
                ['nome' => 'OUTROS']
            ]
        );
    }
}
