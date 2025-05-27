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
        return Student::select('city as name', 
                         DB::raw('count(*) as total'),
                         DB::raw('avg(family_income) as income'),
                         DB::raw('(count(*) * 100.0 / (SELECT count(*) FROM students)) as percentage'))
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->get()
            ->map(function ($location) {
                return [
                    'name' => $location->name,
                    'total' => $location->total,
                    'income' => number_format($location->income, 2),
                    'percentage' => round($location->percentage, 1)
                ];
            })
            ->toArray();
    }

    public function getLocationStatistics(): JsonResponse
    {
        return response()->json($this->getLocationStats());
    }
}
