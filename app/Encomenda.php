<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encomenda extends Model
{
    public function itens()
    {
        return $this->hasMany(ItemEncomenda::class);
    }
}
