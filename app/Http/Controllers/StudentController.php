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
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return Inertia::render('StudentList', [
            'students' => $students,
            'filters' => ['search' => $search],
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
            'year_level' => 'required|string|max:255',
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
            'year_level' => 'required|string|max:255',
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
}
