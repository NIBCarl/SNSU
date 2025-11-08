<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $stats = $this->getStats();
        $locationStats = $this->getLocationStats();

        return Inertia::render('Dashboard', [
            'auth' => [
                'user' => auth()->user()
            ],
            'stats' => $stats,
            'locationStats' => $locationStats
        ]);
    }

    public function getStats(): array
    {
        $totalStudents = Student::count();
        $indigenousPeople = Student::where('ethnicity', 'Indigenous')->count();
        $pwd = Student::where('pwd', true)->count();
        $renting = Student::where('housing_status', 'Renting')->count();

        return [
            'totalStudents' => $totalStudents,
            'indigenousPeople' => $indigenousPeople,
            'pwd' => $pwd,
            'renting' => $renting,
        ];
    }

    public function getDashboardStats(): JsonResponse
    {
        return response()->json($this->getStats());
    }

    public function getLocationStats(): array
    {
        $locations = Student::select('city as name', 
                         DB::raw('count(*) as total'),
                         DB::raw('SUM(CASE WHEN ethnicity = "Indigenous" THEN 1 ELSE 0 END) as indigenous'),
                         DB::raw('SUM(CASE WHEN pwd = 1 THEN 1 ELSE 0 END) as pwd'),
                         DB::raw('SUM(CASE WHEN is_solo_parent = 1 THEN 1 ELSE 0 END) as solo_parent'),
                         DB::raw('(count(*) * 100.0 / (SELECT count(*) FROM students)) as percentage'))
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->get();

        return $locations->map(function ($location) {
            return [
                'name' => $location->name,
                'total' => $location->total,
                'indigenous' => $location->indigenous,
                'pwd' => $location->pwd,
                'soloParent' => $location->solo_parent,
                'percentage' => round($location->percentage, 1)
            ];
        })->toArray();
    }

    public function getLocationStatistics(): JsonResponse
    {
        return response()->json($this->getLocationStats());
    }
}
