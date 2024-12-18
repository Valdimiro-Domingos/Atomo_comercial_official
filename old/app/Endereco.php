<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Endereco extends Model
{
    public $timestamps = false;

    public static function getEntityEnderecoContacto($id, $tabela)
    {
        $dados = DB::table($tabela)
            ->join('enderecos', 'enderecos.id', '=', $tabela . '.id_endereco')
            ->join('contactos', 'contactos.id', '=', $tabela . '.id_contacto')
            ->where([$tabela . '.id' => $id])
            ->select($tabela . '.id as id_tabela', 'enderecos.id as id_endereco', 'contactos.id as id_contacto', $tabela . '.*', 'enderecos.*', 'contactos.*')
            ->get();
        return $dados;
    }
    //Feito Paulo João
    public static function getClientes($tabela){
        $dados = DB::table($tabela)
        ->join('enderecos', 'enderecos.id', '=', $tabela . '.id_endereco')
        ->get();
        return $dados;
    }
    
    public static function getEntityEnderecoContactoCurrent($id, $tabela)
    {
        $dados = DB::table($tabela)
            ->join('enderecos', 'enderecos.id', '=', $tabela . '.id_endereco')
            ->join('contactos', 'contactos.id', '=', $tabela . '.id_contacto')
            ->leftJoin('artigos', 'artigos.id', '=', $tabela . '.id_artigo')
            ->where([$tabela . '.id' => $id])
            ->select($tabela . '.id as id_tabela', 'enderecos.id as id_endereco', 'contactos.id as id_contacto', $tabela . '.*', 'enderecos.*', 'contactos.*', 'artigos.*')
            ->with('loja')
            ->get();
        return $dados;
    }

}
