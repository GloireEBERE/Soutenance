<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
    protected $keyType = 'string'; // UUID sera un string

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'role',
        'contact',
        'email',
        'mot_de_passe', // Mot de passe inclus dans les attributs mass assignables
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'mot_de_passe', // Mot de passe caché lors de la sérialisation
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'mot_de_passe' => 'hashed', // Mot de passe sera haché automatiquement
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
                $model->id = (string) Str::uuid(); // Génère un UUID automatiquement
            }
        });
        
    }

    public function requiresAdditionalInfo()
    {
        if ($this->role === 'stagiaire' && !$this->stagiaire) {
            return true;
        }

        // Ajoutez des vérifications pour d'autres rôles si nécessaire
        return false;
    }

    /**
     * Set the password attribute.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['mot_de_passe'] = bcrypt($value); // Hachage du mot de passe avant de le stocker
    }

    public function stagiaire()
    {
        return $this->hasOne(Stagiaire::class, 'user_id', 'id'); // Relation 1-1
    }

    // Pour que les stagiaires affectés à un tuteur donné s'affichent
    public function stagiaires()
    {
        return $this->hasMany(Stagiaire::class, 'tuteur_id', 'id');
    }

    public function tuteur()
    {
        return $this->hasOne(Tuteur::class, 'user_id', 'id');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id', 'id');
    }

    public function rapports()
    {
        return $this->hasMany(Rapport::class);
    }

}

