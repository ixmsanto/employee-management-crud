<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('educations')->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15',
            'email' => 'required|email|unique:employees,email',
            'address' => 'required|string',
            'profile_picture' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'gender' => 'required|in:Male,Female,Other',
            'educations.*.degree' => 'required|string',
            'educations.*.institution' => 'required|string',
            'educations.*.year' => 'required|digits:4',
        ]);

        $data = $request->all();
        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('profiles', 'public');
        }

        $employee = Employee::create($data);

        foreach ($request->educations as $education) {
            $employee->educations()->create($education);
        }

        return response()->json(['message' => 'Employee created successfully']);
    }

    public function show(Employee $employee)
    {
        $employee->load('educations');
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $employee->load('educations');
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'address' => 'required|string',
            'profile_picture' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'gender' => 'required|in:Male,Female,Other',
            'educations.*.degree' => 'required|string',
            'educations.*.institution' => 'required|string',
            'educations.*.year' => 'required|digits:4',
        ]);

        $data = $request->all();
        if ($request->hasFile('profile_picture')) {
            if ($employee->profile_picture) {
                Storage::disk('public')->delete($employee->profile_picture);
            }
            $data['profile_picture'] = $request->file('profile_picture')->store('profiles', 'public');
        }

        $employee->update($data);

        $employee->educations()->delete();
        foreach ($request->educations as $education) {
            $employee->educations()->create($education);
        }

        return response()->json(['message' => 'Employee updated successfully']);
    }

    public function destroy(Employee $employee)
    {
        if ($employee->profile_picture) {
            Storage::disk('public')->delete($employee->profile_picture);
        }
        $employee->delete();
        return response()->json(['message' => 'Employee deleted successfully']);
    }
}
