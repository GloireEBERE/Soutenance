<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tache extends Model
{
    use HasFactory;

    const STATUT_TERMINEE = 'terminée';
    const STATUT_ANNULEE = 'annulée';

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
        'titre_tache',
        'description_tache',
        'date_debut',
        'date_fin',
        'statut',
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
     * Get the stagiaire that owns the tache.
     */
    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class, 'stagiaire_id', 'id');
    }
}

