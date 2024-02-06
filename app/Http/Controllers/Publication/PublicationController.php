<?php

namespace App\Http\Controllers\Publication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\PublicationResource;
use App\Models\Publication;
use Illuminate\Support\Facades\Auth;

class PublicationController extends Controller
{

    // Publication::class -> Indica el nombe del Policy - report -> nombre ruta
    public function __construct()
    {
        // https://laravel.com/docs/9.x/authorization#authorizing-resource-controllers
        $this->authorizeResource(Publication::class, 'report');
    }



    // Métodos del Controlador
    // Listar las publicaciones
    public function index()
    {
        // Se obtiene el usuario autenticado
        $user = Auth::user();

        // Listado para Administrador y estudiante
        if($user->role->slug === "administrador" || $user->role->slug === "estudiante"){

            // Obtener todas las publicaciones
            $adm = Publication::where('state', 1)->get();

            return $this->sendResponse(message: 'Publication list generated successfully', result: [
                'reports' => PublicationResource::collection($adm)
            ]);
        }

        // Del usuario se obtiene las publicaciones
        $reports = $user->publication()->where('state', 1)->get();
        // Invoca el controlador padre para la respuesta json
        // El moldeo de la información por el Resource
        return $this->sendResponse(message: 'Publication list generated successfully', result: [
            'reports' => PublicationResource::collection($reports)
        ]);
    }

    // Crear una nueva publicacion
    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $request -> validate([
            'Titulo' => ['required', 'string', 'min:3', 'max:45'],
            'Descripcion' => ['required', 'string', 'min:3', 'max:45'],
            'Beneficios' => ['required', 'string', 'min:3', 'max:45'],
            'Procedimiento' => ['required', 'string', 'min:3', 'max:45'],
            
        ]);

        // Del request se obtiene unicamente los dos campos
        $report_data = $request->only(['Titulo', 'Descripcion', 'Beneficios', 'Procedimiento']);
        // Se crea una nueva instancia (en memoria)
        $report = new Publication($report_data);
        // Se obtiene el usuario autenticado
        $user = Auth::user();
        // Del usuario se almacena su publicacion en base a la relación
        // https://laravel.com/docs/9.x/eloquent-relationships#the-save-method
        $user->publication()->save($report);
        

        // Invoca el controlador padre para la respuesta json
        return $this->sendResponse(message: 'Publication stored successfully');
    }

    // Mostrar la información de la publicacion
    public function show(Publication $report)
    {
        // Verifica si el estado de la publicación no es 1
        if ($report->state != 1) {
            // Si el estado no es 1, puedes devolver una respuesta diferente o lanzar una excepción
            return $this->sendResponse(message: 'This publication is inactive or deleted.');
        }

        // Invoca el controlador padre para la respuesta json
        // El moldeo de la información por el Resource
        return $this->sendResponse(message: 'Publication details', result: [
            'report' => new PublicationResource($report),
        ]);
    }

    // Actualizar la información del reporte
    public function update(Request $request, Publication $report)
    {
       
        // Validación de los datos de entrada
        $request -> validate([
            'Titulo' => ['required', 'string', 'min:3', 'max:45'],
            'Descripcion' => ['required', 'string', 'min:3', 'max:45'],
            'Beneficios' => ['required', 'string', 'min:3', 'max:45'],
            'Procedimiento' => ['required', 'string', 'min:3', 'max:45'],
        ]);

        // Del request se obtiene unicamente los cuatro campos
        $report_data = $request->only(['Titulo', 'Descripcion', 'Beneficios', 'Procedimiento']);


        // Actaliza los datos del reporte
        $report->fill($report_data)->save();

        
        // Invoca el controlador padre para la respuesta json
        
        return $this->sendResponse(message: 'Publication updated successfully');
    }

    // Dar de baja a un pabellon
    public function destroy(Publication $report)
    {
        // Obtener el estado del reporte
        $report_state = $report->state;
        // Almacenar un string con el mensaje
        $message = $report_state ? 'inactivated' : 'activated';
        // Cambia el estado del pabellon
        $report->state = !$report_state;
        // Guardar en la BDD
        $report->save();
        // Invoca el controlador padre para la respuesta json
        return $this->sendResponse(message: "Publication $message successfully");
    }

  
    
    
}
