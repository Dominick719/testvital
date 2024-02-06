<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        // Se procede a definir la estructura de la respuesta de la petición
        // https://laravel.com/docs/9.x/eloquent-resources#introduction
        return [
            'username' => $this->username,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'birthdate' => $this->birthdate,
            'home_phone' => $this->home_phone,
            'personal_phone' => $this->personal_phone,
            'address' => $this->address,
        ];


    }
}
