<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdutoServico extends Model
{
    protected $fillable = [
        'type', 'code', 'group', 'description', 'number_code', 'details', 'unnumber', 'valor_aquisicao', 'valor_venda', 'fornecedor_id'
    ];

    protected $table = 'produto_servicos';

    /** 
     * Return todos productos em Stocks
     * @return ProductoServico
    */
    public function ProductoEmStock()
    {
        
    }

     
}
