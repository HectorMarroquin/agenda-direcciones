<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function telefonos()
    {
        return $this->hasMany(Telefono::class);
    }

    public function correos()
    {
        return $this->hasMany(Correo::class);
    }

    public function direcciones()
    {
        return $this->hasMany(Direccion::class);
    }
}
