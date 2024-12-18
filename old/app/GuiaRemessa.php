<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuiaRemessa extends Model
{
    public function itens()
    {
        return $this->hasMany(ItemGuiaRemessa::class);
    }
}