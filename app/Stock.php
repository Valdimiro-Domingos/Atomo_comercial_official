<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stock extends Model
{

    public function itens()
    {
        return $this->hasMany(ItemStock::class);
    }


    public static function getStock( $startDate, $endDate)
    {
        $dados  = DB::table('artigos')
            ->select(
                'artigos.codigo',
                'artigos.designacao',
                'artigos.preco',
                DB::raw('COALESCE((SELECT SUM(items.qtd) FROM items WHERE items.artigo_id = artigos.id AND items.created_at BETWEEN ? AND ?), 0) as qtd_faturas'),
                DB::raw('COALESCE((SELECT SUM(item_factura_recibos.qtd) FROM item_factura_recibos WHERE item_factura_recibos.artigo_id = artigos.id AND item_factura_recibos.created_at BETWEEN ? AND ?), 0) as qtd_factura_recibos'),
                DB::raw('COALESCE((SELECT SUM(item_nota_debitos.qtd) FROM item_nota_debitos WHERE item_nota_debitos.artigo_id = artigos.id AND item_nota_debitos.created_at BETWEEN ? AND ?), 0) as qtd_nota_debitos'),
                DB::raw('COALESCE((SELECT SUM(item_nota_creditos.qtd) FROM item_nota_creditos WHERE item_nota_creditos.artigo_id = artigos.id AND item_nota_creditos.created_at BETWEEN ? AND ?), 0) as qtd_nota_creditos'),
                DB::raw('COALESCE((SELECT SUM(item_stocks.qtd) FROM item_stocks WHERE item_stocks.artigo_id = artigos.id AND item_stocks.created_at BETWEEN ? AND ?), 0) as stock')
            )
            ->setBindings([$startDate, $endDate, $startDate, $endDate, $startDate, $endDate, $startDate, $endDate, $startDate, $endDate])
            ->get();




        return $dados;
    }
}
