<?php

namespace App;

use App\Stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Artigo extends Model
{
    //busca tados as aquisicoes de um determinado artigo
    public function aquisicoes()
    {
        return $this->hasMany(Stock::class);
    }

    //busca o total de stock de um determinida artigo
    public function totalStock(){
        return DB::select('SELECT SUM(stocks.qtd) as totalQtd FROM stocks WHERE stocks.status = 1 AND stocks.artigo_id = :idProd',['idProd' => $this->id])[0];  
    }
}
