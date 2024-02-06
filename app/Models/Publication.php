<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

   

    protected $fillable = [
        'Titulo', 'average', 'user_id','id', 'Descripcion', 'Beneficios', 'Procedimiento', 'state',
        
    ];

    // Relación de uno a muchos
    // Una publicacion le pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación de uno a muchos
    //  Una publicacion puede tener muchos favoritos
    public function favorite()
    {
        return $this->hasmany(Favorite::class);
    }
   

    

   



}
