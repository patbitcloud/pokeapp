<?php

namespace App\Http\Controllers;

use App\Models\UserPokemonDislike;
use App\Models\UserPokemonLike;

class UserPokemonController extends Controller
{
    //get user likes and dislikes pokemon
    public function userPokemon()
    {
        $likedPokemons = UserPokemonLike::with(['user'])->where('user_id', auth()->id())->get();
        $dislikedPokemons = UserPokemonDislike::with(['user'])->where('user_id', auth()->id())->get();

        return response()->json(compact('likedPokemons', 'dislikedPokemons'));
    }
}
