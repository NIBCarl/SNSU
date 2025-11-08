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
                         DB::raw('(count(*) * 100.0 / (SELECT count(*) FROM students)) as percentage'))
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->get();

        return $locations->map(function ($location) {
            // Get all students from this city and calculate average income
            $studentsInCity = Student::where('city', $location->name)->get();
            $incomeSum = 0;
            $incomeCount = 0;

            foreach ($studentsInCity as $student) {
                $numericIncome = $this->convertIncomeToNumeric($student->family_income);
                if ($numericIncome > 0) {
                    $incomeSum += $numericIncome;
                    $incomeCount++;
                }
            }

            $averageIncome = $incomeCount > 0 ? $incomeSum / $incomeCount : 0;

            return [
                'name' => $location->name,
                'total' => $location->total,
                'indigenous' => $location->indigenous,
                'pwd' => $location->pwd,
                'income' => number_format($averageIncome, 2),
                'percentage' => round($location->percentage, 1)
            ];
        })->toArray();
    }

    /**
     * Convert income string range to numeric value (using midpoint of range)
     */
    private function convertIncomeToNumeric($incomeString): float
    {
        if (!$incomeString || $incomeString === 'N/A') {
            return 0;
        }

        // Remove "Php" and spaces, keep only numbers and dash
        $cleaned = str_replace(['Php ', 'Php', ',', ' '], '', $incomeString);

        // Handle "X & Below" case
        if (stripos($cleaned, '&Below') !== false || stripos($cleaned, 'Below') !== false) {
            $value = (float) preg_replace('/[^0-9.]/', '', $cleaned);
            return $value / 2; // Use half of the upper limit as midpoint
        }

        // Handle "X and above" case
        if (stripos($cleaned, 'above') !== false) {
            $value = (float) preg_replace('/[^0-9.]/', '', $cleaned);
            return $value * 1.2; // Use 120% as estimate for "above" category
        }

        // Handle range "X - Y"
        if (strpos($cleaned, '-') !== false) {
            $parts = explode('-', $cleaned);
            if (count($parts) === 2) {
                $lower = (float) $parts[0];
                $upper = (float) $parts[1];
                return ($lower + $upper) / 2; // Return midpoint
            }
        }

        // If single number, return as is
        return (float) preg_replace('/[^0-9.]/', '', $cleaned);
    }

    public function getLocationStatistics(): JsonResponse
    {
        return response()->json($this->getLocationStats());
    }
}
