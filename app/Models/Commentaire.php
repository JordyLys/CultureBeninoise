<?php

namespace App\Models;




// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Commentaire extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'texte',
        'note',
        'idUsers',
        'idContenu',
    ];
    protected $table = 'commentaire';
     public function user()
    {
        return $this->belongsTo(User::class, 'idUsers');
    }

    public function contenu()
    {
        return $this->belongsTo(Contenu::class, 'idContenu');
    }


}
