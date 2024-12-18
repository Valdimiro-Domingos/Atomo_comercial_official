<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    public function itens()
    {
        return $this->hasMany(ItemProforma::class);
    }
    
    public function clienteOne()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
