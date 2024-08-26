<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function getNotifications(Request $request)
{
    try {
        // Validate and decode region_ids
        $regionIds = json_decode($request->input('region_ids'), true);
        if (!is_array($regionIds)) {
            return response()->json(['error' => 'Invalid region IDs'], 400);
        }

        // Ensure start_date and end_date are valid dates
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if (!strtotime($startDate) || !strtotime($endDate)) {
            return response()->json(['error' => 'Invalid date format'], 400);
        }

        $notifications = DB::table('notification')
            ->join('modules', 'notification.module_id', '=', 'modules.module_id')
            ->join('gateways', 'modules.module_gtw_id', '=', 'gateways.module_gtw_id')
            ->whereIn('gateways.region_number', $regionIds)
            ->whereBetween('notification.date', [$startDate, $endDate])
            ->select('notification.Type', 'notification.Description', 'notification.date')
            ->get()
            ->groupBy('Type'); // Group by notification type

        return response()->json($notifications);
    } catch (\Exception $e) {
        \Log::error('Error fetching notifications: ' . $e->getMessage());
        return response()->json(['error' => 'Server Error'], 500);
    }
}

    

}
