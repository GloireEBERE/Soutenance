<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Stagiaire extends Model
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
        'date_de_naissance',
        'commentaire',
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
                $model->id = (string) Str::uuid(); // Génère un UUID automatiquement pour l'identifiant
            }
        });
    }

    /**
     * Get the user that owns the Stagiaire.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); // Relation inverse
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class, 'stagiaire_id', 'id');
    }

    public function rapports()
    {
        return $this->hasMany(Rapport::class);
    }

    public function projets()
    {
        return $this->belongsToMany(Projet::class, 'projet_stagiaire', 'stagiaire_id', 'projet_id');
    }

    public function tuteur()
    {
        return $this->belongsTo(Tuteur::class, 'tuteur_id', 'id');
    }

    public function taches()
    {
        return $this->hasMany(Tache::class, 'stagiaire_id', 'id');
    }


}