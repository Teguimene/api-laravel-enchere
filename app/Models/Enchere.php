<?php

namespace App\Models;

use App\Models\User;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enchere extends Model
{
    use HasFactory;

    protected $fillable = [
        'prix_enchere',
        'produit_id',
        'user_id',
    ];

    public function produit() {
        return $this->belongsTo(Produit::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
