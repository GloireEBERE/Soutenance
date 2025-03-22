<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Rapport extends Model
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
        'stagiaire_id',
        'theme_rapport',
        'document_rapport',
        'date_soumission',
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
                $model->id = (string) Str::uuid(); // Génère automatiquement un UUID
            }
        });
    }

    /**
     * Get the stagiaire that owns the rapport.
     */
    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }

    public function user()
    {
        return $this->hasOne(User::class,);
    }
}

