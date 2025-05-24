<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function generateUniqueRandomString($length = 10)
    {
        do {
            // Generate a random string of uppercase letters and numbers
            $randomString = strtoupper(Str::random($length));
            $randomString = preg_replace('/[a-z]/', '', $randomString); // Ensure it's uppercase and numbers only

            // Check if the string already exists in the database
            $exists = User::where('token', $randomString)->exists();

        } while ($exists); // Keep generating until we find a unique string

        return $randomString;
    }

    public function setPasswordAttribute($value)
    {

        $this->attributes['password'] = Hash::make($value);
    }

}
