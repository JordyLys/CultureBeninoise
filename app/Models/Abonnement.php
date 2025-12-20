<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'guest_id',
        'type',
        'contenus_max',
        'contenus_lus',
        'date_debut',
        'date_fin',
        'transaction_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
      public function estValide()
    {
        return $this->date_fin > now();
    }
}
