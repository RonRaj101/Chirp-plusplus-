<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use App\Helpers\AppHelper;
use Illuminate\Support\Facades\App;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        //get all chirps from the authenticated user
        $relevantChirps = Chirp::with('user:id,name')->where('user_id', Auth::id())->latest()->get();

        //append number of likes and if the authenticated user has liked the chirp
        AppHelper::appendLikes($relevantChirps);

        return Inertia::render('Chirps/Index', [
            //modified to only show chirps from the authenticated user, get all likes for each chirp
            'chirps' => $relevantChirps
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
            //'privacy' can either be 'priv' or 'publ'
            'privacy_status' => 'required|in:priv,publ',
        ]);

        $request->user()->chirps()->create($validated);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function show(Chirp $chirp)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function edit(Chirp $chirp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        
 
        $validated = $request->validate([
            'message' => 'required|string|max:255',
            //'privacy' can either be 'priv' or 'publ'
            'privacy_status' => 'required|in:priv,publ',
        ]);

        Gate::authorize('update', $chirp);
        $chirp->update($validated);
        
        //redirect to page where it came from
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chirp $chirp) :RedirectResponse
    {
        Gate::authorize('delete', $chirp);
 
        $chirp->delete();
 
        return redirect()->back();
    }
}
