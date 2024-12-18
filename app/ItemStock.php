<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemStock extends Model
{
    public function artigo()
    {
        return $this->belongsTo(Artigo::class);
    }
}
