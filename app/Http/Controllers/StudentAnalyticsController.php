<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class StudentAnalyticsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('StudentAnalytics', [
            'stats' => $this->getDemographicStats(),
            'locationStats' => $this->getLocationStats()
        ]);
    }

    public function getDemographics(): JsonResponse
    {
        return response()->json([
            'totalStudents' => Student::count(),
            'genderStats' => [
                'male' => Student::where('gender', 'Male')->count(),
                'female' => Student::where('gender', 'Female')->count(),
                'other' => Student::where('gender', 'Other')->count(),
            ],
            'transportStats' => Student::select('transportation_mode', DB::raw('count(*) as count'))
                ->groupBy('transportation_mode')
                ->pluck('count', 'transportation_mode'),
            'incomeStats' => Student::select('family_income_bracket', DB::raw('count(*) as count'))
                ->groupBy('family_income_bracket')
                ->pluck('count', 'family_income_bracket'),
            'avgTravelTime' => round(Student::avg('travel_time_minutes')),
            'locationStats' => $this->getLocationStats(),
            'indigenousCount' => Student::where('ethnicity', 'Indigenous')->count(),
            'pwdCount' => Student::where('pwd', true)->count(),
            'rentingCount' => Student::where('housing_status', 'Renting')->count(),
        ]);
    }

    private function getLocationStats(): array
    {
        return Student::select('city',
            DB::raw('count(*) as total'),
            DB::raw('avg(household_size) as avgHouseholdSize'),
            DB::raw('avg(travel_time_minutes) as avgTravelTime'))
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'city' => $item->city,
                    'total' => $item->total,
                    'avgHouseholdSize' => round($item->avgHouseholdSize, 1),
                    'avgTravelTime' => round($item->avgTravelTime),
                    'avgIncomeBracket' => $this->getAverageIncomeBracket($item->city)
                ];
            })
            ->toArray();
    }

    private function getAverageIncomeBracket(string $city): string
    {
        $brackets = Student::where('city', $city)
            ->select('family_income_bracket', DB::raw('count(*) as count'))
            ->groupBy('family_income_bracket')
            ->orderBy('count', 'desc')
            ->first();

        return $brackets ? $brackets->family_income_bracket : 'N/A';
    }

    private function getDemographicStats(): array
    {
        return [
            'genderDistribution' => Student::select('gender', DB::raw('count(*) as total'))
                ->groupBy('gender')
                ->get(),
            'transportationMode' => Student::select('transportation_mode', DB::raw('count(*) as total'))
                ->groupBy('transportation_mode')
                ->get(),
            'averageTravelTime' => Student::avg('travel_time_minutes'),
            'incomeDistribution' => Student::select('family_income_bracket', DB::raw('count(*) as total'))
                ->groupBy('family_income_bracket')
                ->get(),
            'socioDemo' => [
                'indigenous' => Student::where('ethnicity', 'Indigenous')->count(),
                'pwd' => Student::where('pwd', true)->count(),
                'renting' => Student::where('housing_status', 'Renting')->count(),
            ]
        ];
    }
}
