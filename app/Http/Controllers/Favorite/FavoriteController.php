<?php

namespace App\Http\Controllers\Favorite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\FavoriteResource;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{

    // Publication::class -> Indica el nombe del Policy - report -> nombre ruta
    public function __construct()
    {
        // https://laravel.com/docs/9.x/authorization#authorizing-resource-controllers
        $this->authorizeResource(Favorite::class, 'report');
    }


        

    // Métodos del Controlador
    // Listar los favoritos
    public function index()
    {
        
        // Se obtiene el usuario autenticado
        $user = Auth::user();

        // Del usuario se obtienen los favoritos con estado 1
        $reports = $user->favorite()->where('state', 1)->get();
        
        // El moldeo de la información por el Resource
        return $this->sendResponse(message: 'Favorite Publication list generated successfully', result: [
            'reports' => FavoriteResource::collection($reports)
        ]);
    }

    // Crear un nuevo favorito
    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $request -> validate([
            'publicacion_id' => ['required', 'numeric'],
            'calificacion'   => ['nullable', 'numeric'],
            'feedback' => ['nullable', 'string', 'min:3', 'max:45'],
        ]);

        // Comprobacion calificacion
        $calificacion = $request->input('calificacion');
        if ($calificacion !== null && ($calificacion > 5 || $calificacion < 1)) {
            return $this->sendResponse(message: 'La calificacion ingresada debe estar entre 1 y 5');
        }
        
        // Del request se obtiene unicamente un campo
        $publicacion_id = $request->only(['publicacion_id']);

        // Del request se obtiene unicamente un campo
        $report_data = $request->only(['publicacion_id','calificacion','feedback']);

        // Se crea una nueva instancia (en memoria)
        $report = new Favorite($report_data);
        // Se obtiene el usuario autenticado
        $user = Auth::user();

        // Verifica si ya existe un favorito con el mismo publicacion_id para el usuario
        if ($user->favorite()->where('publicacion_id', $publicacion_id['publicacion_id'])->where('state', 1)->exists()) {
            // El favorito ya existe, devuelve un mensaje de error
            return $this->sendResponse('La publicacion ya está registrada como favorita para este usuario.');
        }

        // Del usuario se almacena su favorito en base a la relación
        $user->favorite()->save($report);
        
        // Invoca el controlador padre para la respuesta json
        return $this->sendResponse(message: 'Favorite stored successfully');
    }

    // Actualizar la información del favorito
    public function update(Request $request, Favorite $report)
    {
    
        // Validación de los datos de entrada
        $request->validate([
            'calificacion' => ['required', 'numeric'],
            'feedback' => ['nullable', 'string', 'min:3', 'max:45'],
        ]);
        
        // Del request se obtiene unicamente la calificacion
        $report_data = $request->only(['calificacion','feedback']);
        $calificacion = $request->only(['calificacion'])['calificacion'];

        // Comprobacion calificacion
        if ($calificacion > 5 || $calificacion < 1){
            return $this->sendResponse(message: 'La calificacion ingresada debe estar entre 1 y 5');
        }

        // Actaliza los datos del reporte
        $report->fill($report_data)->save();

        // Invoca el controlador padre para la respuesta json
        return $this->sendResponse(message: 'Favorito updated successfully');
    }

    // Mostrar la información del Favorito
    public function show(Favorite $report)
    {

        // Verifica si el estado de la publicación no es 1
        if ($report->state != 1) {
            // Si el estado no es 1, puedes devolver una respuesta diferente o lanzar una excepción
            return $this->sendResponse(message: 'This favorite is inactive or deleted.');
        }

        // Invoca el controlador padre para la respuesta json
        // El moldeo de la información por el Resource
        return $this->sendResponse(message: 'Favorite details', result: [
            'report' => new FavoriteResource($report),
        ]);
    }


    // Quitar de favorito una publicación
    public function destroy(Favorite $report)
    {
        // Obtener el estado del reporte
        $report_state = $report->state;
        // Almacenar un string con el mensaje
        $message = $report_state ? 'inactivated' : 'activated';
        // Cambia el estado del favorito
        $report->state = !$report_state;
        // Guardar en la BDD
        $report->save();
        // Invoca el controlador padre para la respuesta json
        return $this->sendResponse(message: "Favorite $message successfully");
    }
    
    
}
