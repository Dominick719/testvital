<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Publication;
use App\Models\Favorite;

class QualificationResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        // Creo una instancia del modelo Favorite, con todas las publicaciones de su de $this->id
        $favorito = Favorite::where('publicacion_id', $this->id)->get();
        // Creo una instancia del modelo publicacion, con el id de la publicacione para resource
        $publicacion = Publication::find($this->id);
   

        return [
            'Publication_id' => $this->id,
            'Title' => $this->Titulo,
            'Average' => $this->average,
            'Calification' => ResultResource::collection($favorito),
            'Publication details' => new PublicationResource($publicacion),
            
        ];
    }
}


