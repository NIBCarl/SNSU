<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $course = $request->input('course', '');
        $yearLevel = $request->input('year_level', '');
        $gender = $request->input('gender', '');
        $city = $request->input('city', '');
        $ethnicity = $request->input('ethnicity', '');
        $housingStatus = $request->input('housing_status', '');
        $pwdOnly = $request->input('pwd_only', false);
        
        $perPage = 10;
        $newStudentId = $request->session()->get('new_student_id');

        $students = Student::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('middle_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('student_id', 'like', "%{$search}%")
                        ->orWhere('course', 'like', "%{$search}%")
                        ->orWhere('year_level', 'like', "%{$search}%")
                        ->orWhere('religion', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhere('barangay', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('province', 'like', "%{$search}%");
                });
            })
            ->when($course, function ($query, $course) {
                $query->where('course', $course);
            })
            ->when($yearLevel, function ($query, $yearLevel) {
                $query->where('year_level', $yearLevel);
            })
            ->when($gender, function ($query, $gender) {
                $query->where('gender', $gender);
            })
            ->when($city, function ($query, $city) {
                $query->where('city', $city);
            })
            ->when($ethnicity, function ($query, $ethnicity) {
                $query->where('ethnicity', $ethnicity);
            })
            ->when($housingStatus, function ($query, $housingStatus) {
                $query->where('housing_status', $housingStatus);
            })
            ->when($pwdOnly, function ($query) {
                $query->where('pwd', true);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        // Get unique filter options from database
        $filterOptions = [
            'courses' => Student::distinct()->orderBy('course')->pluck('course')->filter()->values(),
            'yearLevels' => ['1st Year', '2nd Year', '3rd Year', '4th Year', 'Others'],
            'genders' => ['Male', 'Female', 'Other'],
            'cities' => Student::distinct()->orderBy('city')->pluck('city')->filter()->values(),
            'ethnicities' => ['Indigenous', 'Non-Indigenous'],
            'housingStatuses' => ['Owned', 'Renting', 'Living with Relatives', 'Other'],
        ];

        return Inertia::render('StudentList', [
            'students' => $students,
            'filters' => [
                'search' => $search,
                'course' => $course,
                'year_level' => $yearLevel,
                'gender' => $gender,
                'city' => $city,
                'ethnicity' => $ethnicity,
                'housing_status' => $housingStatus,
                'pwd_only' => $pwdOnly,
            ],
            'filterOptions' => $filterOptions,
            'newStudentId' => $newStudentId,
            'flash' => [
                'message' => $request->session()->get('message')
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'student_id' => 'required|string|unique:students',
            'course' => 'required|string|max:255',
            'year_level' => 'required|in:1st Year,2nd Year,3rd Year,4th Year,Others',
            'gender' => 'required|in:Male,Female,Other',
            'birth_date' => 'required|date',
            'marital_status' => 'required|in:Single,Married',
            'religion' => 'required|string|max:255',
            'cellphone_number' => 'nullable|string|max:20',
            'address' => 'required|string',
            'barangay' => 'required|string',
            'city' => 'required|string',
            'province' => 'required|string',
            'postal_code' => 'required|string',
            'study_device' => 'nullable|in:Laptop,Tablet,Desktop,Mobile Phone',
            'is_solo_parent' => 'boolean',
            'solo_parent_id' => 'nullable|string|max:255',
            'has_part_time_job' => 'boolean',
            'daily_fare' => 'nullable|numeric|min:0',
            'monthly_rental' => 'nullable|numeric|min:0',
            'family_income_bracket' => 'required|string',
            'household_size' => 'required|integer',
            'parents_education' => 'required|string',
            'transportation_mode' => 'required|string',
            'travel_time_minutes' => 'required|integer',
            'ethnicity' => 'required|in:Indigenous,Non-Indigenous',
            'pwd' => 'boolean',
            'housing_status' => 'required|in:Owned,Renting,Living with Relatives,Other',
            'family_income' => 'required|numeric|min:0',
        ]);

        $student = Student::create($validated);
        
        session()->flash('new_student_id', $student->id);
        session()->flash('message', 'Student added successfully!');

        return redirect()->route('thank-you');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return Inertia::render('EditStudent', [
            'student' => $student
        ]);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'student_id' => 'required|string|unique:students,student_id,' . $student->id,
            'course' => 'required|string|max:255',
            'year_level' => 'required|in:1st Year,2nd Year,3rd Year,4th Year,Others',
            'gender' => 'required|in:Male,Female,Other',
            'birth_date' => 'required|date',
            'marital_status' => 'required|in:Single,Married',
            'religion' => 'required|string|max:255',
            'cellphone_number' => 'nullable|string|max:20',
            'address' => 'required|string',
            'barangay' => 'required|string',
            'city' => 'required|string',
            'province' => 'required|string',
            'postal_code' => 'required|string',
            'study_device' => 'nullable|in:Laptop,Tablet,Desktop,Mobile Phone',
            'is_solo_parent' => 'boolean',
            'solo_parent_id' => 'nullable|string|max:255',
            'has_part_time_job' => 'boolean',
            'daily_fare' => 'nullable|numeric|min:0',
            'monthly_rental' => 'nullable|numeric|min:0',
            'family_income_bracket' => 'required|string',
            'household_size' => 'required|integer',
            'parents_education' => 'required|string',
            'transportation_mode' => 'required|string',
            'travel_time_minutes' => 'required|integer',
            'ethnicity' => 'required|in:Indigenous,Non-Indigenous',
            'pwd' => 'boolean',
            'housing_status' => 'required|in:Owned,Renting,Living with Relatives,Other',
            'family_income' => 'required|numeric|min:0',
        ]);

        $student->update($validated);
        
        session()->flash('message', 'Student updated successfully!');
        
        return redirect('/student-list');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->forceDelete();
        
        session()->flash('message', 'Student deleted successfully!');
        
        return redirect('/student-list');
    }

    public function export(Request $request)
    {
        // Get same filters from index method
        $search = $request->input('search', '');
        $course = $request->input('course', '');
        $yearLevel = $request->input('year_level', '');
        $gender = $request->input('gender', '');
        $city = $request->input('city', '');
        $ethnicity = $request->input('ethnicity', '');
        $housingStatus = $request->input('housing_status', '');
        $pwdOnly = $request->input('pwd_only', false);
        $page = $request->input('page', 1);
        $format = $request->input('format', 'csv');
        
        $perPage = 10;

        // Query with same logic as index() but get current page only
        $students = Student::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('middle_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('student_id', 'like', "%{$search}%")
                        ->orWhere('course', 'like', "%{$search}%")
                        ->orWhere('year_level', 'like', "%{$search}%")
                        ->orWhere('religion', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhere('barangay', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('province', 'like', "%{$search}%");
                });
            })
            ->when($course, function ($query, $course) {
                $query->where('course', $course);
            })
            ->when($yearLevel, function ($query, $yearLevel) {
                $query->where('year_level', $yearLevel);
            })
            ->when($gender, function ($query, $gender) {
                $query->where('gender', $gender);
            })
            ->when($city, function ($query, $city) {
                $query->where('city', $city);
            })
            ->when($ethnicity, function ($query, $ethnicity) {
                $query->where('ethnicity', $ethnicity);
            })
            ->when($housingStatus, function ($query, $housingStatus) {
                $query->where('housing_status', $housingStatus);
            })
            ->when($pwdOnly, function ($query) {
                $query->where('pwd', true);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);
        
        $currentPageStudents = $students->items();
        
        // Export based on format
        if ($format === 'csv' || $format === 'excel') {
            return $this->exportCSV($currentPageStudents, $format);
        } elseif ($format === 'pdf') {
            return $this->exportPDF($currentPageStudents);
        }
        
        return redirect('/student-list');
    }

    private function exportCSV($students, $format)
    {
        // Both CSV and Excel will use CSV format (Excel can open CSV files)
        $filename = $format === 'excel' ? 'students.xls' : 'students.csv';
        
        // Use Excel MIME type for .xls, CSV for .csv
        $contentType = $format === 'excel' ? 'application/vnd.ms-excel' : 'text/csv';
        
        $headers = [
            'Content-Type' => $contentType,
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($students) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Add headers
            fputcsv($file, [
                'Student ID',
                'Name',
                'Course',
                'Year Level',
                'Address',
                'Gender',
                'Marital Status',
                'Religion',
                'Family Income',
                'Study Device'
            ]);

            // Add data
            foreach ($students as $student) {
                fputcsv($file, [
                    $student->student_id,
                    trim($student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name),
                    $student->course,
                    $student->year_level,
                    $student->address . ', ' . $student->barangay . ', ' . $student->city . ', ' . $student->province,
                    $student->gender,
                    $student->marital_status,
                    $student->religion,
                    $student->family_income_bracket,
                    $student->study_device ?? 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportPDF($students)
    {
        // Serve as HTML that can be printed to PDF
        return response()->view('exports.students-pdf', ['students' => $students])
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'inline; filename="students.html"');
    }
}
