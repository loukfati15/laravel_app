<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GatewayDataController extends Controller
{
    public function getGatewayData()
    {
        // Fetch data from the gateway
        $gatewayData = DB::table('gateways')
            ->select('date', 
            'module_gtw_id', 
            'num_Sim', 
            'gwt_id', 
            'latitude', 
            'longitude', 
            'nb_hives', 
            'apiary', 
            'user_id', 
            'region_number', 
            'ip_address', 
            'status', 
            'bme_ext')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return response()->json($gatewayData);
    }
}
