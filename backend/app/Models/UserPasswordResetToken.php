<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPasswordResetToken extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $table    = 'user_password_reset_tokens';
    protected $guarded  = ['id'];
    protected $fillable = ['token'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
