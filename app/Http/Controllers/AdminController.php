<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Result;
use Carbon\Carbon;

class AdminController extends Controller
{
    // === Locations Management ===
    
    public function locationsIndex()
    {
        $locations = Location::orderBy('sort_order')->get();
        return view('admin.locations', compact('locations'));
    }

    public function locationsStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'result_time' => 'nullable|string|max:255',
            'sort_order' => 'integer'
        ]);

        Location::create($request->all());
        return back()->with('success', 'Location created successfully.');
    }

    public function locationsUpdate(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'result_time' => 'nullable|string|max:255',
            'sort_order' => 'integer',
            'is_active' => 'boolean'
        ]);

        $location->update([
            'name' => $request->name,
            'result_time' => $request->result_time,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active')
        ]);
        
        return back()->with('success', 'Location updated successfully.');
    }

    // === Results Management ===
    
    public function resultsIndex(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $locations = Location::where('is_active', true)->orderBy('sort_order')->get();
        
        // Fetch existing results for this date
        $results = Result::where('result_date', $date)->get()->keyBy('location_id');

        return view('admin.results', compact('locations', 'date', 'results'));
    }

    public function resultsStore(Request $request)
    {
        $date = $request->input('date');
        $numbers = $request->input('numbers'); // array of location_id => lucky_number
        
        if (!$date || !$numbers) {
            return back()->with('error', 'Invalid data provided.');
        }

        foreach ($numbers as $location_id => $number) {
            if ($number !== null && trim($number) !== '') {
                Result::updateOrCreate(
                    ['location_id' => $location_id, 'result_date' => $date],
                    ['lucky_number' => $number]
                );
            } else {
                // If the field is left blank, we might want to delete the existing result or just leave it. 
                // Let's delete it so it shows 'WAIT' on the frontend
                Result::where('location_id', $location_id)->where('result_date', $date)->delete();
            }
        }

        return back()->with('success', 'Results saved for ' . $date);
    }
}
