<?php

namespace App\Models\Generales;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class Usuarios extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = "Usuarios";
    protected $primaryKey = 'Id_Usuario';
    public $timestamps = false; 
    protected $fillable = [
        'Id_Usuario',
        'Email',
        'Contrasena',
        'Estatus',
        'Id_Persona',
        'Id_Rol',
        'Tipo_Usuario',
        'Primer_Cambio_Contrasena'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function adminlte_image()
    {
        return 'img/user.png';
    }

    public function adminlte_desc()
    {
        return Auth::user()->Email;
    }

    public function adminlte_profile_url()
    {
        return 'perfil-administrador';
    }
}
