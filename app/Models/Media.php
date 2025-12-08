<?php

namespace App\Models;



// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Media extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'chemin',
        'description',
        'idTypeMedia',
        'idContenu'
    ];
     public function typeMedia()
    {
        return $this->belongsTo(TypeContenu::class, 'idTypeContenu');
    }

    public function contenu()
    {
        return $this->belongsTo(Contenu::class, 'idContenu');
    }



}
