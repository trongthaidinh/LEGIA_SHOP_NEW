<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WebsiteVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_date', 
        'total_visits', 
        'ip_address', 
        'user_agent', 
        'page_visited'
    ];

    public static function recordVisit($page = null)
    {
        $today = Carbon::today()->toDateString();
        $ipAddress = request()->ip();
        $userAgent = request()->userAgent();

        // Check if this IP has already visited today
        $existingVisit = self::where('visit_date', $today)
            ->where('ip_address', $ipAddress)
            ->where('page_visited', $page)
            ->first();

        if (!$existingVisit) {
            // Create a new visit record
            self::create([
                'visit_date' => $today,
                'total_visits' => 1,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'page_visited' => $page
            ]);
        }
    }

    public static function getTodayVisits()
    {
        return self::where('visit_date', Carbon::today()->toDateString())
            ->count();
    }

    public static function getTotalVisits()
    {
        return self::sum('total_visits');
    }

    public static function getVisitStats()
    {
        return [
            'today_visits' => self::getTodayVisits(),
            'total_visits' => self::getTotalVisits()
        ];
    }
}
