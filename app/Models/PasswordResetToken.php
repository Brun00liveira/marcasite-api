<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    protected $table = 'password_reset_tokens';

    // Desative os timestamps se não for necessário
    public $timestamps = false;

    // Campos que podem ser atribuídos em massa
    protected $fillable = ['email', 'token', 'created_at'];

    public static function getTokenByEmail($email)
    {
        return self::where('email', $email)->first();
    }
}
