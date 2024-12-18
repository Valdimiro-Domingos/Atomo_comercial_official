<?php

namespace App\Http\Resources;

use App\Endereco; 
use App\Contacto; 
use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"=> $this->id,
            "codigo"=> $this->codigo,
            "designacao"=> $this->designacao,
            "contribuinte"=> $this->contribuinte,
            "zona"=> $this->zona,
            "identificacao"=> $this->identificacao,
            "observacao"=> $this->observacao,
            "imagem"=> $this->imagem,
            "status"=>$this->status,
            "is_used"=> $this->is_used,
            "endereco"=> EnderecoResource::make($this->endereco),
            "contacto"=> ContactoResource::make($this->contacto),
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at
        ];
    }
}
