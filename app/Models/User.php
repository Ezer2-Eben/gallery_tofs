<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'age',
        'gender',
        'enabled',
        'created_at',
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = false;

    protected $casts = [
        'enabled' => 'boolean',
        'age' => 'integer',
    ];

    // Relations
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    // Accesseurs
    public function getCreatedAtFormattedAttribute()
    {
        if ($this->created_at) {
            try {
                return \Carbon\Carbon::parse($this->created_at)->format('d/m/Y H:i');
            } catch (\Exception $e) {
                return 'Date inconnue';
            }
        }
        return 'Date inconnue';
    }

    public function getFullNameAttribute()
    {
        $name = trim($this->first_name . ' ' . $this->last_name);
        return $name ?: $this->username;
    }

    public function getIsAdminAttribute()
    {
        return $this->id === 1;
    }
}