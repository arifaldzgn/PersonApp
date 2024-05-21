<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\workout;
use App\Models\variation;
use App\Models\muscleGroup;
use Illuminate\Http\Request;
use App\Models\workoutSession;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreworkoutRequest;
use App\Http\Requests\UpdateworkoutRequest;

class WorkoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view ('record', [
            'muscleGroups' => muscleGroup::all()
        ]);
    }


    public function add_record(Request $request)
    {
         // Validate the incoming request data
         $validatedData = $request->validate([
            'date' => 'required|date',
            'notes' => 'nullable|string',
            'sessions.*.variation' => 'required|exists:variations,id',
            'sessions.*.sets' => 'required|integer|min:1',
            'sessions.*.reps' => 'required|integer|min:1',
            'sessions.*.weight' => 'nullable|numeric|min:0',
        ]);

        // Create a new workout instance
        $workout = new workout();
        $workout->user_id = 1;
        $workout->date = $validatedData['date'];
        $workout->notes = $validatedData['notes'];
        $workout->save();

        // Store each session associated with the workout
        foreach ($validatedData['sessions'] as $sessionData) {
            $session = new workoutSession();
            $session->workout_id = $workout->id;
            $session->variation_id = $sessionData['variation'];
            $session->sets = $sessionData['sets'];
            $session->reps = $sessionData['reps'];
            $session->weight = $sessionData['weight'];
            $session->save();
        }

        // Optionally, you can redirect the user to a success page or return a JSON response
        return response()->json(['message' => 'Workout created successfully']);
    }

    public function fetch_variation(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'muscleGroupId' => 'required|exists:muscle_groups,id'
        ]);

        // Fetch variations based on the selected muscle group ID
        $variations = variation::where('muscle_group_id', $request->muscleGroupId)->get();

        // Return variations as JSON response
        return response()->json($variations);
    }

    public function record_list()
    {
        //

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $workoutsMay = workout::whereBetween('date', [$startDate, $endDate])->get();

        return view ('record_list', [
            'workoutsMay' => $workoutsMay
        ]);
    }

    public function getSessions($workoutId)
    {
        // Retrieve workout sessions for the specified workout
        $workout = workout::findOrFail($workoutId);
        $workoutSession = $workout->workoutSession;

        // If workout sessions are not found, initialize an empty array
        if ($workoutSession === null) {
            $workoutSession = [];
        }

        // dd($workoutSession);


        // Return the Blade view with the workout session data
        return view('workout_sessions', compact('workout', 'workoutSession'));
    }

    public function test()
    {
        $data = muscleGroup::find(1);
        $data2 = $data->variation;

        dd($data2);
    }

    public function showProgressiveOverload()
    {
        // Get dates for the current and previous week
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek();
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek();

        // Fetch and aggregate data for this week
        $thisWeekData = DB::table('workout_sessions')
            ->join('workouts', 'workout_sessions.workout_id', '=', 'workouts.id')
            ->join('variations', 'workout_sessions.variation_id', '=', 'variations.id')
            ->join('muscle_groups', 'variations.muscle_group_id', '=', 'muscle_groups.id')
            ->whereBetween('workouts.date', [$startOfWeek, $endOfWeek])
            ->select('muscle_groups.name as muscle_group', DB::raw('SUM(workout_sessions.weight) as total_weight'))
            ->groupBy('muscle_groups.name')
            ->get()
            ->keyBy('muscle_group')
            ->toArray();

        // Fetch and aggregate data for last week
        $lastWeekData = DB::table('workout_sessions')
            ->join('workouts', 'workout_sessions.workout_id', '=', 'workouts.id')
            ->join('variations', 'workout_sessions.variation_id', '=', 'variations.id')
            ->join('muscle_groups', 'variations.muscle_group_id', '=', 'muscle_groups.id')
            ->whereBetween('workouts.date', [$startOfLastWeek, $endOfLastWeek])
            ->select('muscle_groups.name as muscle_group', DB::raw('SUM(workout_sessions.weight) as total_weight'))
            ->groupBy('muscle_groups.name')
            ->get()
            ->keyBy('muscle_group')
            ->toArray();

        return view('progressive-overload', compact('thisWeekData', 'lastWeekData'));
    }

    // Chest Only
    public function showProgressiveOverloadChest()
    {
        // Get dates for the current and previous week
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek();
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek();

        // Fetch and aggregate data for this week
        $thisWeekDataChest = DB::table('workout_sessions')
            ->join('workouts', 'workout_sessions.workout_id', '=', 'workouts.id')
            ->join('variations', 'workout_sessions.variation_id', '=', 'variations.id')
            ->join('muscle_groups', 'variations.muscle_group_id', '=', 'muscle_groups.id')
            ->where('muscle_groups.name', 'Chest')
            ->whereBetween('workouts.date', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('SUM(workout_sessions.weight) as total_weight'))
            ->pluck('total_weight')
            ->first();

        // Fetch and aggregate data for last week
        $lastWeekDataChest = DB::table('workout_sessions')
            ->join('workouts', 'workout_sessions.workout_id', '=', 'workouts.id')
            ->join('variations', 'workout_sessions.variation_id', '=', 'variations.id')
            ->join('muscle_groups', 'variations.muscle_group_id', '=', 'muscle_groups.id')
            ->where('muscle_groups.name', 'Chest')
            ->whereBetween('workouts.date', [$startOfLastWeek, $endOfLastWeek])
            ->select(DB::raw('SUM(workout_sessions.weight) as total_weight'))
            ->pluck('total_weight')
            ->first();

        $thisWeekDataChest = $thisWeekDataChest ?? 0;
        $lastWeekDataChest = $lastWeekDataChest ?? 0;


        // Back
        $thisWeekDataBack = DB::table('workout_sessions')
            ->join('workouts', 'workout_sessions.workout_id', '=', 'workouts.id')
            ->join('variations', 'workout_sessions.variation_id', '=', 'variations.id')
            ->join('muscle_groups', 'variations.muscle_group_id', '=', 'muscle_groups.id')
            ->where('muscle_groups.name', 'Back')
            ->whereBetween('workouts.date', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('SUM(workout_sessions.weight) as total_weight'))
            ->pluck('total_weight')
            ->first();

        $lastWeekDataBack = DB::table('workout_sessions')
            ->join('workouts', 'workout_sessions.workout_id', '=', 'workouts.id')
            ->join('variations', 'workout_sessions.variation_id', '=', 'variations.id')
            ->join('muscle_groups', 'variations.muscle_group_id', '=', 'muscle_groups.id')
            ->where('muscle_groups.name', 'Back')
            ->whereBetween('workouts.date', [$startOfLastWeek, $endOfLastWeek])
            ->select(DB::raw('SUM(workout_sessions.weight) as total_weight'))
            ->pluck('total_weight')
            ->first();

        $thisWeekDataBack = $thisWeekDataBack ?? 0;
        $lastWeekDataBack = $lastWeekDataBack ?? 0;

        // Legs
        $thisWeekDataLegs = DB::table('workout_sessions')
            ->join('workouts', 'workout_sessions.workout_id', '=', 'workouts.id')
            ->join('variations', 'workout_sessions.variation_id', '=', 'variations.id')
            ->join('muscle_groups', 'variations.muscle_group_id', '=', 'muscle_groups.id')
            ->where('muscle_groups.name', 'Legs')
            ->whereBetween('workouts.date', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('SUM(workout_sessions.weight) as total_weight'))
            ->pluck('total_weight')
            ->first();

        $lastWeekDataLegs = DB::table('workout_sessions')
            ->join('workouts', 'workout_sessions.workout_id', '=', 'workouts.id')
            ->join('variations', 'workout_sessions.variation_id', '=', 'variations.id')
            ->join('muscle_groups', 'variations.muscle_group_id', '=', 'muscle_groups.id')
            ->where('muscle_groups.name', 'Legs')
            ->whereBetween('workouts.date', [$startOfLastWeek, $endOfLastWeek])
            ->select(DB::raw('SUM(workout_sessions.weight) as total_weight'))
            ->pluck('total_weight')
            ->first();

        $thisWeekDataLegs = $thisWeekDataLegs ?? 0;
        $lastWeekDataLegs = $lastWeekDataLegs ?? 0;

        // Arms
        $thisWeekDataArms = DB::table('workout_sessions')
            ->join('workouts', 'workout_sessions.workout_id', '=', 'workouts.id')
            ->join('variations', 'workout_sessions.variation_id', '=', 'variations.id')
            ->join('muscle_groups', 'variations.muscle_group_id', '=', 'muscle_groups.id')
            ->where('muscle_groups.name', 'Arms')
            ->whereBetween('workouts.date', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('SUM(workout_sessions.weight) as total_weight'))
            ->pluck('total_weight')
            ->first();

        $lastWeekDataArms = DB::table('workout_sessions')
            ->join('workouts', 'workout_sessions.workout_id', '=', 'workouts.id')
            ->join('variations', 'workout_sessions.variation_id', '=', 'variations.id')
            ->join('muscle_groups', 'variations.muscle_group_id', '=', 'muscle_groups.id')
            ->where('muscle_groups.name', 'Arms')
            ->whereBetween('workouts.date', [$startOfLastWeek, $endOfLastWeek])
            ->select(DB::raw('SUM(workout_sessions.weight) as total_weight'))
            ->pluck('total_weight')
            ->first();

        $thisWeekDataArms = $thisWeekDataArms ?? 0;
        $lastWeekDataArms = $lastWeekDataArms ?? 0;

        // Shoulder
        $thisWeekDataShoulders = DB::table('workout_sessions')
            ->join('workouts', 'workout_sessions.workout_id', '=', 'workouts.id')
            ->join('variations', 'workout_sessions.variation_id', '=', 'variations.id')
            ->join('muscle_groups', 'variations.muscle_group_id', '=', 'muscle_groups.id')
            ->where('muscle_groups.name', 'Shoulders')
            ->whereBetween('workouts.date', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('SUM(workout_sessions.weight) as total_weight'))
            ->pluck('total_weight')
            ->first();

        $lastWeekDataShoulders = DB::table('workout_sessions')
            ->join('workouts', 'workout_sessions.workout_id', '=', 'workouts.id')
            ->join('variations', 'workout_sessions.variation_id', '=', 'variations.id')
            ->join('muscle_groups', 'variations.muscle_group_id', '=', 'muscle_groups.id')
            ->where('muscle_groups.name', 'Shoulders')
            ->whereBetween('workouts.date', [$startOfLastWeek, $endOfLastWeek])
            ->select(DB::raw('SUM(workout_sessions.weight) as total_weight'))
            ->pluck('total_weight')
            ->first();

        $thisWeekDataShoulders = $thisWeekDataShoulders ?? 0;
        $lastWeekDataShoulders = $lastWeekDataShoulders ?? 0;

        // Abs
        $thisWeekDataAbs = DB::table('workout_sessions')
            ->join('workouts', 'workout_sessions.workout_id', '=', 'workouts.id')
            ->join('variations', 'workout_sessions.variation_id', '=', 'variations.id')
            ->join('muscle_groups', 'variations.muscle_group_id', '=', 'muscle_groups.id')
            ->where('muscle_groups.name', 'Abs')
            ->whereBetween('workouts.date', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('SUM(workout_sessions.weight) as total_weight'))
            ->pluck('total_weight')
            ->first();

        $lastWeekDataAbs = DB::table('workout_sessions')
            ->join('workouts', 'workout_sessions.workout_id', '=', 'workouts.id')
            ->join('variations', 'workout_sessions.variation_id', '=', 'variations.id')
            ->join('muscle_groups', 'variations.muscle_group_id', '=', 'muscle_groups.id')
            ->where('muscle_groups.name', 'Abs')
            ->whereBetween('workouts.date', [$startOfLastWeek, $endOfLastWeek])
            ->select(DB::raw('SUM(workout_sessions.weight) as total_weight'))
            ->pluck('total_weight')
            ->first();

        $thisWeekDataAbs = $thisWeekDataAbs ?? 0;
        $lastWeekDataAbs = $lastWeekDataAbs ?? 0;

        return view('dashboard', compact('thisWeekDataChest', 'lastWeekDataChest', 'thisWeekDataBack', 'lastWeekDataBack', 'thisWeekDataLegs', 'lastWeekDataLegs', 'thisWeekDataArms', 'lastWeekDataArms', 'thisWeekDataShoulders', 'lastWeekDataShoulders', 'thisWeekDataAbs', 'lastWeekDataAbs'));
    }


}
