<?php

// app/Http/Controllers/RegionController.php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegionController extends Controller
{
    public function getRegions()
    {
        try {
            // Fetch regions data, converting the geometry to GeoJSON format
            $regions = DB::table('regions')
                ->select('id', 'region_name', 'region_number', 'country', 'gateway_count', DB::raw('ST_AsGeoJSON(geom) as geom'))
                ->get();

            return response()->json($regions);
        } catch (\Exception $e) {
            Log::error('Error fetching regions: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching regions'], 500);
        }
    }

    public function getRegionsBySuperuser($superuserId)
    {
        try {
            $regions = DB::table('regions')
                ->join('region_superuser', 'regions.id', '=', 'region_superuser.region_id')
                ->where('region_superuser.superuser_id', $superuserId)
                ->select('regions.id', 'regions.region_name', 'regions.region_number', DB::raw('ST_AsGeoJSON(geom) as geom'))
                ->get();

            return response()->json($regions);
        } catch (\Exception $e) {
            Log::error('Error fetching superuser regions: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching superuser regions'], 500);
        }
    }
}
