<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    public function itens()
    {
        return $this->hasMany(Item::class);
    }

    public function recibos()
    {
        return $this->hasMany(ItemRecibo::class, 'documento_id', 'id');
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'id', 'id_cliente');
    }
    
    public function clienteOne()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
