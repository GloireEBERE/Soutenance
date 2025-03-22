<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Héritage de Authenticatable
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Admin extends Authenticatable // Hérite de Authenticatable pour permettre l'authentification
{
    use HasFactory;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The primary key type.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
    ];

    /**
     * Automatically generates UUID for primary key if it's not set.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // Génération automatique de l'UUID
            }
        });
    }

    /**
     * Get the user that owns the Admin.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
