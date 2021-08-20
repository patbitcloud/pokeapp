<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //get all list of users and their likes and dislikes pokemon 
    public function index(Request $request)
    {
        $users = User::with(['likedPokemon', 'dislikedPokemon'])
            ->selectRaw("id, first_name, last_name, CONCAT(first_name, ' ', last_name) as full_name")
            ->where('id', '!=', auth()->id());

        $search = $request->search;

        if ($search) {
            $users->where('first_name', 'like', "%$search%")->orWhere('last_name', 'like', "%$search%");
        }

        return $users->paginate(10);
    }

    //update user profile
    public function updateUserProfile(User $user, Request $request)
    {
        $validated = $request->validate([
            'email' => ['sometimes', 'required', 'string', Rule::unique('users')->ignore($user->id)],
            'first_name' => ['sometimes', 'required', 'string'],
            'last_name' => ['sometimes', 'required', 'string'],
            'birth_date' => ['sometimes', 'required', 'date']
        ]);

        $user->update($validated);

        return response()->json(['message' => 'Profile has been updated.']);
    }

    //update user password
    public function updateUserPassword(User $user, Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            'new_password_confirmation' => ['required', 'string', 'min:8'],
        ]);

        $user = Auth::user();

        $user_id = $user->id;
        $hashed_user_password = $user->password;

        if (Hash::check($validated['current_password'], $hashed_user_password)) {

            User::findOrFail($user_id)->update([
                'password' => Hash::make($validated['new_password']),
            ]);

            Auth::logout();

            return response()->json([
                'message' => 'Your password has been successfully changed.',
            ]);
        }

        return response()->json([
            'message' => 'The given data was invalid',
            'errors' => [
                'current_password' => [
                    'Your current password is incorrect',
                ],
            ],
        ], 422);
    }
}
