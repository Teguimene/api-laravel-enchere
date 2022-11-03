<?php

namespace App\Http\Controllers;

use App\Models\Enchere;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = DB::table('produits')->select('*')->paginate(20);
        return response([
            'status' => 200,
            'produits' => [$produits],
        ]);
    }

    //Afficher les produits par nom
    public function produitByName(Request $request) {
        $attrs = $request->validate([
            'nom_produit' => 'required'
        ]);
        $produits = DB::table('produits')
            ->select('*')
            ->where('nom_produit', $attrs['nom_produit'])
            ->get();

        if(count($produits) == 0) {
            return response([
                'message' => 'Aucun produit trouvé'
            ], 403);
        } else{
            return response([
                'satatus' => 200,
                'produits' => $produits
            ], 200);
        }
    }
    //Afficher un produit specifique
    public function show($id) {
        return response([
            'produit' => Produit::find($id),
        ]);
    }

    //Ajout du produit
    public function store(Request $request) {

        // $name = Storage::disk('local')->put('produits', $request->picture);
        // dd(Storage::url($name));
        $attrs = $request->validate([
            'nom_produit' => 'required|string',
            'description_produit' => 'required|string',
            'image_produit',
            'prix' => 'required|integer',
        ]);

            $produit = Produit::create([
                'nom_produit' => $attrs['nom_produit'],
                'description_produit' => $attrs['description_produit'],
                'image_produit' => null,
                'prix' => $attrs['prix'],
            ]);

            return response([
                'status' => 200,
                'message' => 'produit crée'
            ]);
    }

    public function edit(Produit $produit)
    {
        //
    }

    public function update(Request $request, Produit $produit)
    {
        //
    }

    public function destroy(Produit $produit)
    {
        //
    }
}
