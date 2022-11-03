<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
   public function register(Request $request) {
        //Validation du formulaire
        $attrs = $request->validate([
            'name' => "required|string",
            'email' => "required|email|unique:users,email",
            'password' => "required|min:6|confirmed"
        ]);
        //creation de l'utilisateur
        $user = User::create([
            'name' => $attrs['name'],
            'email' => $attrs['email'],
            'password' => bcrypt($attrs['password']),
        ]);
        //Retourner l'utilisateur et la piece dans la reponse
        $token = $user->createToken('token-name', ['server:update'])->plainTextToken;

        return response([
            'client_info' => $user,
            'token' => $token
        ], 200);
    }

     //Connexion de l'Utilisateur
    public function login(Request $request) {
        //Validation du formulaire
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        
        //tentative de connexion
        $user = User::where('email', '=', $request['email'])->first();
        if($user) {
            if(Hash::check($request->password, $user->password)) {
                //creer un jeton/token
                $token = $user->createToken('auth_token')->plainTextToken;
                return response([
                    'status' => 200,
                    'message' => 'Connexion reussie',
                    'access_token'=> $token,
                    'user_name' => $user->name,
                    'user_id' => $user->id
                ], 200);
            } else {
                return response([
                    'status' => 403,
                    'message' => 'Mot de passe incorrect'
                ], 403);
            }

        } else {
            return response([
                'status' => 404,
                'message' => 'Utilisateur introuvable'
            ], 404);
        }
    }

    //Deconnexio Utilisateur

    public function logout(User $user) {
        $user->tokens()->delete();
        return response([
            'message' => 'Deconnexion réussie.'
        ], 200);
    }


}
