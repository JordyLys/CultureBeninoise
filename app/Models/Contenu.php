<?php

namespace App\Models;



// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Contenu extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    'titre',
    'texte',
    'statut',
    'dateCreation',
    'dateValidation',
    'idTypeContenu',
    'idParent',
    'idModerateur',
    'idAuteur',
    'idRegion',
    'idLangue',
    'photo',
];
 protected $casts = [
        'dateCreation' => 'datetime',
        'dateValidation' => 'datetime',
    ];


    // Relation avec Media (1 contenu = 1 média)
    public function media()
    {
        return $this->hasOne(Media::class, 'idContenu');
    }

    // Relation avec TypeContenu
    public function typeContenu()
    {
        return $this->belongsTo(TypeContenu::class, 'idTypeContenu');
    }



    // Relation avec Auteur (User)
    public function auteur()
    {
        return $this->belongsTo(User::class, 'idAuteur');
    }


    public function region()
    {
        return $this->belongsTo(Region::class, 'idRegion');
    }

    public function langue()
    {
        return $this->belongsTo(Langue::class, 'idLangue');
    }
      public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'idContenu');
    }


}
