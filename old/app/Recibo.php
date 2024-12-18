<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    public function itens()
    {
        return $this->hasMany(ItemRecibo::class);
    }
        
    public function clienteOne()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
