<?php

namespace App\Http\Controllers;

use App\Models\Chirp;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ],
        ], [
            'message.required' => 'Please write something to chirp!',
            'message.max' => 'Chirps must be 255 characters or less.',
        ]);

        // Create the chirp (no user for now - we'll add auth later)
        $request->user()->chirps()->create($validated);

        // Redirect back to the feed
        return redirect('/')->with('success', 'Chirp created!');
    }

    public function edit(Request $request, Chirp $chirp)
    {
        if ($request->user()->cannot('update', $chirp)) {
            abort(403);
        }

        return view('chirps.edit', compact('chirp'));
    }

    public function update(Request $request, Chirp $chirp)
    {
        if ($request->user()->cannot('update', $chirp)) {
            abort(403);
        }

        // Validate
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        // Update
        $chirp->update($validated);

        return redirect('/')->with('success', 'Chirp updated!');
    }

    public function destroy(Request $request, Chirp $chirp)
    {
        if ($request->user()->cannot('delete', $chirp)) {
            abort(403);
        }

        $chirp->delete();

        return redirect('/')->with('success', 'Chirp deleted!');
    }
}
