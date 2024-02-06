<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;



class PublicationResource extends JsonResource
{
    
    public function toArray(Request $request)
    {
        // Se procede a definir la estructura de la respuesta de la petición
        // https://laravel.com/docs/9.x/eloquent-resources#introduction
        return [
            'Id' => $this->id,
            'Titulo' => $this->Titulo,
            'state' => $this->state,
            'Descripcion' => $this->Descripcion,
            'Beneficios' => $this->Beneficios,
            'Procedimiento' => $this->Procedimiento,
            'created_by' => new UserResource($this->user),
            //'created_at' => $this->created_at->toDateTimeString(),
            // https://carbon.nesbot.com/docs/
            //'created_at' => $this->created_at->toDateTimeString(),
            // https://laravel.com/docs/9.x/eloquent-resources#resource-collections
            //'organizador' => UserResource::collection($this->users),
        ];


    }
}

