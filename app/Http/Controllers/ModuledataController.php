<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModuledataController extends Controller
{
    public function getDataForAnalysis(Request $request)
    {
        try {
            // Validate input
            $regionIds = json_decode($request->input('region_ids'), true);
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            if (!is_array($regionIds) || !strtotime($startDate) || !strtotime($endDate)) {
                return response()->json(['error' => 'Invalid input'], 400);
            }

            // Fetch data from the module_data table
            $moduleData = DB::table('module_data')
                ->join('modules', 'module_data.module_id', '=', 'modules.module_id')
                ->join('gateways', 'modules.module_gtw_id', '=', 'gateways.module_gtw_id')
                ->join('regions', 'gateways.region_number', '=', 'regions.region_number')
                ->whereIn('gateways.region_number', $regionIds)
                ->whereBetween('module_data.date', [$startDate, $endDate])
                ->select(
                    'module_data.date', 
                    'module_data.temperature', 
                    'module_data.pressure', 
                    'module_data.humidity',
                    'module_data.battery_life',
                    'module_data.battery_level',
                    'regions.region_name'
                )
                ->orderBy('module_data.date', 'asc')
                ->get()
                ->toArray(); // Ensure it is an array

            return response()->json($moduleData);

        } catch (\Exception $e) {
            \Log::error('Error fetching module data: ' . $e->getMessage());
            return response()->json(['error' => 'Server Error'], 500);
        }
    }
}
