<?php

namespace App\Models;

use App\Models\Enchere;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produit extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_produit',
        'description_produit',
        'image_produit',
        'prix',
        'created_at',
        'updated_at'
    ]; 

    public function encheres() {
        return $this->hasMany(Enchere::class);
    }
}
