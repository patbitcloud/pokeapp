<?php

namespace App\Http\Controllers;

use App\Models\UserPokemonDislike;
use App\Models\UserPokemonLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserPokemonLikeController extends Controller
{
    private $limit = 3;

    //trigger function like button to save user_pokemon_likes table
    public function addToLikes(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'url' => ['required', 'string']
        ]);

        $authID = auth()->id();

        $message = ['message' => 'Pokemon liked.'];

        $checkDislikePokemon = UserPokemonDislike::where([['user_id', $authID], ['pokemon', $validated['name']]]); //check user pokemon dislikes exists

        if ($checkDislikePokemon->exists() === true) {
            $this->insertLikedPokemon($validated, $checkDislikePokemon);

            return response()->json($message);
        }

        $limitReached = UserPokemonLike::where('user_id', $authID)->count() >= $this->limit;

        if ($limitReached === false) {

            $this->insertLikedPokemon($validated, $checkDislikePokemon);

            return response()->json($message);
        }

        return response()->json(['message' => 'Pokemon likes limit reached.'], 422);
    }

    private function insertLikedPokemon($validated, $checkDislikePokemon)
    {
        DB::transaction(function () use ($validated, $checkDislikePokemon) {
            $checkDislikePokemon->delete();

            auth()->user()->likedPokemon()->create([
                'pokemon' => $validated['name'],
                'pokemon_url' => $validated['url']
            ]);
        });
    }

    public function myPokemonLikes()
    {
        return UserPokemonLike::where('user_id', auth()->id())->get();
    }
}
