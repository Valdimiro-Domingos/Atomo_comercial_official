<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'id_endereco');
    }
    
    public function contacto(){
        return $this->belongsTo(Contacto::class, 'id_contacto');
    }
    
    public function loja()
    {
        return $this->belongsTo(Artigo::class, 'id_artigo', 'id')->select('designacao');
    }
    
    public function nomeLoja(){
        return $this->belongsTo(Artigo::class, 'id_artigo', 'id')->select('designacao')
        ->withDefault(['designacao' => '']);
    }
    
    
}
