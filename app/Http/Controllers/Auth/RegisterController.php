<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\User;

class RegisterController extends Controller
{
    // Crear un nuevo usuario
    public function store(Request $request)
    {
        
        // Validación de los datos de entrada
        $request -> validate([
            'first_name' => ['required', 'string', 'min:3', 'max:35'],
            'last_name' => ['required', 'string', 'min:3', 'max:35'],
            'username' => ['required', 'string', 'min:5', 'max:20', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string'],
            'personal_phone' => ['required', 'numeric', 'digits:10'],
            //'home_phone' => ['required', 'numeric', 'digits:9'],
            'address' => ['required', 'string', 'min:5', 'max:50'],
        ]);

        // Obtiene el rol del usuario
        $role = Role::where('slug', 'estudiante')->first();
        // Crear una instancia del usuario
        $user = new User($request->all());
        
        // Se almacena el usuario en la BDD
        $role->users()->save($user);
        
        // Invoca el controlador padre para la respuesta json
        return $this->sendResponse(message: 'User register successfully');
    }
}
