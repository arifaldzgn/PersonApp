<?php

namespace App\Http\Controllers;

use App\Models\variation;
use App\Models\muscleGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoremuscleGroupRequest;
use App\Http\Requests\UpdatemuscleGroupRequest;

class MuscleGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('muscleGroup', ['data' => muscleGroup::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function variation($id)
    {
        $d = variation::where('muscle_group_id', $id)->get();
        // dd(muscleGroup::find($id)->name);
        return view('variation', [
            'data' => $d,
            'muscle' => muscleGroup::find($id)
        ]);
    }

    public function addVariation(Request $request)
    {


        $validatedData = $request->validate([
            'muscle_group_id'   => 'required',
            'name'              => 'required',
            'description'       => 'required',
            'equipment'         => 'required',
            'difficulty'        => 'required'
        ]);


        try {
            // Use mass assignment to create a new variation
            variation::create($validatedData);

            // Redirect with success message
            return redirect()->route('variations.index')->with('success', 'variation created successfully.');

        } catch (\Exception $e) {
            // Log the error and return with an error message
            Log::error('Error creating variation: ' . $e->getMessage());

            return redirect()->back()->withErrors(['msg' => 'Error creating variation. Please try again.']);
        }

    }
}
