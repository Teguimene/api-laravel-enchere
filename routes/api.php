<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\EnchereController;
use App\Http\Controllers\ProduitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Connexion && Inscription des utilisateurs   
Route::post('/register', [ClientController::class, 'register']);
Route::post('/login', [ClientController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function() {
    //Deconnexion
    Route::post('/logout', [ClientController::class, 'logout']);
    
    //Articles
    Route::get('/produits', [ProduitController::class, 'index']);
    Route::get('/produit-detail/{id}', [ProduitController::class, 'show']);
    Route::post('/produit-detail/{id}', [EnchereController::class, 'enchere']);
    Route::get('/produit-name', [ProduitController::class, 'produitByName']);
    // Route::get('/produit-detail/{id}', [ProduitController::class, 'show']);
    Route::post('/add-produit', [ProduitController::class, 'store']);
});
