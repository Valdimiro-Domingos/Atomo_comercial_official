<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaRecibo extends Model
{
    public function itens()
    {
        return $this->hasMany(ItemFacturaRecibo::class);
    }
    
    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'id', 'cliente_id');
    }
    
    public function clienteOne()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
