<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Publication;
use App\Models\User;

class ResultResource extends JsonResource
{
   
    public function toArray(Request $request): array
    {
        // Creo una instancia del modelo Publication, con los datos de $this->publicacion_id
        $prueba = Publication::find($this->publicacion_id);
        $usuario = User::find($this->user_id);



        return [
            'id' => $this->id,
            'state' => $this->state,
            'user_id' => $this->user_id,
            'User_name' => $usuario->username,
            'Calification' => $this->calificacion,
            'Publicacion_id' => $this->publicacion_id,
            'Feedback' => $this->feedback,
        ];
    }
}
