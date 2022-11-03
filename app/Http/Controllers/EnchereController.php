<?php

namespace App\Http\Controllers;

use App\Models\Enchere;
use App\Models\Produit;
use Illuminate\Http\Request;

class EnchereController extends Controller
{
    public function index()
    {
        return response([
            'enchere' => Enchere::orderby('desc','created_at')->limit(5),
        ]);
    }
       // Initier l'enchere
    public function enchere(Request $request, $id) {

        $produit = Produit::find($id);
        $enche = Enchere::all()->last();

        if(!$produit) {
            return response([
                'warning' => 'Impossible de trouver le produit'
            ]);    
        }

        $attrs = $request->validate([
            'prix_enchere' => 'integer|required',
        ]);

        if(!empty($enche)) {
               
                if($attrs['prix_enchere'] < $enche->prix_enchere){
                    return response([
                        'status' => 0,
                        'message' => 'prix inferieur au precedent enchere'
                    ]);
                } else{
                    $enchere = Enchere::Create(
                        [
                        'prix_enchere' => $attrs['prix_enchere'],
                        'produit_id' => $id,
                        'user_id' => auth()->user()->id,
                    ]);
        
                    return response([
                        'status' => 200,
                        'enchere' => $enchere
                    ]);
                }
        }
        $enchere = Enchere::Create(
            [
            'prix_enchere' => $attrs['prix_enchere'],
            'produit_id' => $id,
            'user_id' => auth()->user()->id,
        ]);

        return response([
            'enchere' => $enchere
        ]);
    }

}
