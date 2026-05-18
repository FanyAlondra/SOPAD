<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Nombre de la tabla
    protected $table = 'usuario';

    // Llave primaria
    protected $primaryKey = 'id_usuario';

    // Tu tabla no usa created_at ni updated_at
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'correo',
        'contrasena',
        'rol',
        'foto',
        'two_factor_code',
        'two_factor_expires_at'
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    protected $casts = [
        'two_factor_expires_at' => 'datetime',
    ];

    // Laravel usará "contrasena" como password
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    // Campo de login
    public function username()
    {
        return 'correo';
    }

    // Generar código 2FA
    public function generateTwoFactorCode()
    {
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(5);
        $this->save();
    }

    // Reiniciar código 2FA
    public function resetTwoFactorCode()
    {
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }
}