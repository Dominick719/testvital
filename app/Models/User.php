<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Trait\HasImage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasImage;

    
    protected $fillable = [
        'email', 'id','username', 'first_name', 'last_name', 'personal_phone', 'home_phone',
        'address', 'password', 'birthdate',
        
            
        
    ];

    

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relación de uno a muchos
    // Un usuario le pertenece un rol
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relación de uno a muchos
    // Un usuario organizador puede realizar muchos reportes
    public function publication()
    {
        return $this->hasMany(Publication::class);
    }

    // Relación de uno a muchos
    // Un usuario puede tener muchos favoritos
    public function favorite()
    {
        return $this->hasMany(Favorite::class);
    }

    // Relación polimórfica uno a uno
    // Un usuario pueden tener una imagen
    public function image()
    {
        return $this->morphOne(Image::class,'imageable');
    }
    


    // Obtener el nombre completo del usuario
    public function getFullName()
    {
        return "$this->first_name $this->last_name";
    }

    // Crear un avatar por default
    public function getDefaultAvatarPath()
    {
        return "https://cdn-icons-png.flaticon.com/512/711/711769.png";
    }

    // Obtener la imagen de la BDD
    public function getAvatarPath()
    {
        // se verifica no si existe una iamgen
        if (!$this->image)
        {
            // asignarle el path de una imagen por defecto
            return $this->getDefaultAvatarPath();
        }
        // retornar el path de la imagen registrada en la BDD
        return $this->image->path;
    }

    // Metodos para Notificacion
    // Función para saber si el rol que tiene asignado el usuario
    // es el mismo que se le esta pasando a la función
    // https://laravel.com/docs/9.x/eloquent-relationships#one-to-many
    public function hasRole(string $role_slug)
    {
        return $this->role->slug === $role_slug;
    }




}
