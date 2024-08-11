<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chirp;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Likes;
use Illuminate\Support\Facades\Auth;

class LikesController extends Controller
{   

    public function show()
    {
        return Inertia::render('Likes', [
            //Find current user id, then get all chirp ids that user has liked
            $likedChirpIds = User::find(Auth::id())->likes()->get('chirps_id'),
            'likedChirps' => Chirp::whereIn('id', $likedChirpIds)->with('user:id,name')->latest()->get(),
        ]);
    }   

    public function store(Request $request)
    {
        $validated = $request->validate([
            'chirp_id' => 'required|integer|exists:chirps,id',
        ]);

        $request->user()->likes()->create($validated);

        return redirect(route('chirps.index'));
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'chirp_id' => 'required|integer|exists:chirps,id',
        ]);

        Likes::where('user_id', Auth::id())->where('chirp_id', $request->chirp_id)->delete();

        return redirect(route('chirps.index'));
    }

}
