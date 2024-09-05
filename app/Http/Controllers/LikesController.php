<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chirp;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Likes;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AppHelper;

class LikesController extends Controller
{   

    public function show()
    {
        $likedChirpIds = User::find(Auth::id())->likes()->get('chirp_id');
        $likedChirps = Chirp::whereIn('id', $likedChirpIds)->with('user:id,name')->latest()->get();
        AppHelper::appendLikes($likedChirps);
        return Inertia::render('Likes', [
            //Find current user id, then get all chirp ids that user has liked
            'likedChirps' => $likedChirps
        ]);
    }   

    public function store($id)
    {  

        if(Likes::where('user_id', Auth::id())->where('chirp_id', $id)->exists()){
            return;   
        }

        Likes::create([
            'user_id' => Auth::id(),
            'chirp_id' => $id,
        ]);

        return; 
    }

    public function destroy($id)
    {   
        if(!Likes::where('user_id', Auth::id())->where('chirp_id', $id)->exists()){
            return;
        }

        Likes::where('user_id', Auth::id())->where('chirp_id', $id)->delete();
        return;
    }

}
