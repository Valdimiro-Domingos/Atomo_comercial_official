<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaDebito extends Model
{
    public function itens()
    {
        return $this->hasMany(ItemNotaDebito::class);
    }
        
    public function clienteOne()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
