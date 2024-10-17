<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Comments;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|max:255'
        ]);

        $comment = new Comments();
        $comment->message = $request->message;
        $comment->user_id = Auth::id();
        $comment->chirp_id = $request->chirp_id;
        $comment->save();

        return redirect()->back();
    }

}
