<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scientist;

class ScientistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all scientists from the database
        $scientists = Scientist::all();

        // Return the welcome view with the scientists data
        return view('welcome', compact('scientists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return a view for creating a new scientist
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'field' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'year_awarded' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        // Create a new scientist record
        Scientist::create($validatedData);

        // Redirect back to the index with a success message
        return redirect()->route('scientists.index')->with('success', 'Scientist added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Fetch the scientist to be edited
        $scientist = Scientist::findOrFail($id);

        // Return the edit view with the scientist data
        return view('scientists.edit', compact('scientist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'field' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'year_awarded' => 'required|integer|min:1900|max:' . date('Y'),
        ]);
    
        // Find the scientist and update their information
        $scientist = Scientist::findOrFail($id);
        $scientist->update($validatedData);
    
        // Redirect back to the index with a success message
        return redirect()->route('scientists.index')->with('success', 'Scientist updated successfully!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find and delete the scientist
        $scientist = Scientist::findOrFail($id);
        $scientist->delete();

        // Redirect back to the index with a success message
        return redirect()->route('scientists.index')->with('success', 'Scientist deleted successfully!');
    }
}
