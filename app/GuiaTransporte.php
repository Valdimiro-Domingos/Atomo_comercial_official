<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuiaTransporte extends Model
{
    public function itens()
    {
        return $this->hasMany(ItemGuiaTransporte::class);
    }
}
