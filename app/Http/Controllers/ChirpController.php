<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChirpController extends Controller
{
    public function index()
    {
        $chirps = Chirp::with('user')
            ->latest()
            ->take(50)  // Limit to 50 most recent chirps
            ->get();

        return view('home', ['chirps' => $chirps]);
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'message' => [
            'required',
            'string',
            'max:255',
            /*Rule::unique('chirps')->where(function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            })*/
        ],
        ], [
            'message.required' => 'Please write something to chirp!',
            'message.max' => 'Chirps must be 255 characters or less.',
        ]);

        // Create the chirp (no user for now - we'll add auth later)
        \App\Models\Chirp::create([
            'message' => $validated['message'],
            'user_id' => null, // We'll add authentication in lesson 11
        ]);

        // Redirect back to the feed
        return redirect('/')->with('success', 'Chirp created!');
    }
}
