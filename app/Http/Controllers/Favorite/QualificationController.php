<?php

namespace App\Http\Controllers\Favorite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//use App\Http\Resources\FavoriteResource;
use App\Http\Resources\QualificationResource;
//use App\Http\Resources\PublicationResource;
use App\Models\Favorite;
use App\Models\Publication;
use Illuminate\Support\Facades\Auth;

class QualificationController extends Controller
{
    // Métodos del Controlador
    // Listar los favoritos
    public function index()
    {
        // Se obtiene el usuario autenticado
        $user = Auth::user();

        // Obtendo todas las publicaciones cactivas y saco promedio
        $adm = Publication::where('state', 1)->get();
        $this->promedio($adm);

        // Listado de calificaciones estudiante
        if($user->role->slug === "estudiante"){

            // Ordenar las publicaciónes de mayor a menor y obtener 3 primeras
            $adm = $adm->where('state', 1)->sortByDesc('average')->take(3);

            return $this->sendResponse(message: 'Qualification list generated successfully', result: [
                'reports' =>  QualificationResource::collection($adm)
            ]);
        }

        // Listado de calificaciones organizador
        if($user->role->slug === "organizador"){

            // Obtener todas las publicaciones del organizador y que esten activas
            $reports = $user->publication()->where('state', 1)->get();

            return $this->sendResponse(message: 'Qualification organizador list generated successfully', result: [
                'reports' => QualificationResource::collection($reports)
            ]);
        }
        // El moldeo de la información por el Resource
        return $this->sendResponse(message: 'This route is not available for administrator');
    }


    // Mostrar la información de calificacion
    public function show(Favorite $report)
    {
        // Obtendo todas las publicaciones activas y saco promedio
        $adm = Publication::where('state', 1)->get();
        $this->promedio($adm);

        // Publicacion buscada
        $buscada = Publication::find($report->id);

        // Verifica si el estado de la publicación no es 1
        if ($buscada->state != 1) {
            // Si el estado no es 1, puedes devolver una respuesta diferente o lanzar una excepción
            return $this->sendResponse(message: 'This publication is inactive or deleted.');
        }

        // Se obtiene el usuario autenticado
        $user = Auth::user();

        // Listado de calificacion para estudiante
        if($user->role->slug === "estudiante"){

            // Mostrar informacion de la calificacion
            return $this->sendResponse(message: 'Qualification details', result: [
                'report' => new QualificationResource($buscada),
            ]);
        }

        // Listado de calificaciones organizador
        if($user->role->slug === "organizador"){

           
            // Obtengo el id de las Publicaciones del usuario organizador
            $prueba = Publication::where('user_id', $user->id)->get();

            if ($prueba->contains('id', $buscada->id)) {

                return $this->sendResponse(message: 'Qualification organizador detail', result: [
                    'report' => new QualificationResource($buscada),
                ]);
                
            } 
            return $this->sendResponse(message: 'You dont own this Qualification.');
     
        }

        
        // El moldeo de la información por el Resource
        return $this->sendResponse(message: 'This route is not available for administrator');
       
        
    }

    public function promedio($adm){

        foreach ($adm as $publication) {
            
            // Obtengo las calificaciones de la publicaciones y state 1
            $prueba = Favorite::where('publicacion_id', $publication->id)
              ->where('state', 1)
              ->get();
            
            // Obtengo el promedio con dos decimales y guardo
            $publication->update(['average' => round($prueba->avg('calificacion'), 2)]);
        }


    }


}
