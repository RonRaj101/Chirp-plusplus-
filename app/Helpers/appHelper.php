<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Auth;
use App\Models\Chirp;
use App\Models\Like;

class AppHelper{
    public static function appendLikes($relevantChirps){
        //append number of likes and if the authenticated user has liked the chirp
        foreach($relevantChirps as $chirp){
            if($chirp->likes()->where('user_id', Auth::id())->exists()){
                $chirp["liked"] = true;
            }
            else{
                $chirp["liked"] = false;
            }
            $chirp["likes"] = $chirp->likes()->count();
        }
    }
}




?>