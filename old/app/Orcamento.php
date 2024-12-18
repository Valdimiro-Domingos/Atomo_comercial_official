<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    public function itens()
    {
        return $this->hasMany(ItemOrcamento::class);
    }
}
