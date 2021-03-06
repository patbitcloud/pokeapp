<?php

namespace App\Http\Controllers;

use App\Models\UserPokemonDislike;
use App\Models\UserPokemonLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserPokemonDislikeController extends Controller
{

    private $limit = 3;

    //trigger function dislike button to save user_pokemon_dislikes table
    public function addToDislikes(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'url' => ['required', 'string']
        ]);

        $authID = auth()->id();

        $message = ['message' => 'Pokemon disliked.'];

        $checkLikePokemon = UserPokemonLike::where([['user_id', $authID], ['pokemon', $validated['name']]]); //check user pokemon likes exists
        $limitReached = UserPokemonDislike::where('user_id', $authID)->count() >= $this->limit; //check dislikes limits

        if ($checkLikePokemon->exists() === true || $limitReached === false) {

            DB::transaction(function () use ($validated, $checkLikePokemon) {
                $checkLikePokemon->delete();

                auth()->user()->dislikedPokemon()->create([
                    'pokemon' => $validated['name'],
                    'pokemon_url' => $validated['url']
                ]);
            });

            return response()->json($message);
        }

        return response()->json(['message' => 'Pokemon dislikes limit reached.'], 422);
    }

    //get user dislikes pokemons
    public function myPokemonDislikes()
    {
        return UserPokemonDislike::where('user_id', auth()->id())->get();
    }
}
