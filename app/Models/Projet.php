<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Projet extends Model
{
    use HasFactory;

    const STATUT_TERMINE = 'terminé';
    const STATUT_ANNULE = 'annulé';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'titre_projet',
        'description_projet',
        'date_debut',
        'date_fin',
        'statut',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function stagiaires()
    {
        return $this->belongsToMany(Stagiaire::class, 'projet_stagiaire', 'projet_id', 'stagiaire_id');
    }
}

