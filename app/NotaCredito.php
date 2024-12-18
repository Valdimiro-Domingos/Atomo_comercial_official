<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaCredito extends Model
{
    public function itens()
    {
        return $this->hasMany(ItemNotaCredito::class);
    }
        
    public function clienteOne()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
