<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Result;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $locations = Location::where('is_active', true)->orderBy('sort_order')->get();
        
        // 1. Live Results (Today)
        $today = Carbon::today()->toDateString();
        $todayResults = Result::where('result_date', $today)->get()->keyBy('location_id');

        // 2. Monthly Charts
        // We will show the chart for the selected month, defaulting to current month
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        
        $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;
        
        // Fetch all results for this month
        $monthlyResultsData = Result::whereYear('result_date', $year)
            ->whereMonth('result_date', $month)
            ->get();

        // Organize results by [date (day 1-31)][location_id]
        $monthlyResults = [];
        foreach ($monthlyResultsData as $res) {
            $day = $res->result_date->day;
            $monthlyResults[$day][$res->location_id] = $res->lucky_number;
        }

        return view('welcome', compact(
            'locations', 
            'todayResults', 
            'monthlyResults', 
            'daysInMonth',
            'month',
            'year'
        ));
    }
}
