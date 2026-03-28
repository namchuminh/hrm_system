<?php

namespace App\Http\Controllers;

use App\Models\TrainingCourse;
use App\Models\Employee;
use Illuminate\Http\Request;

class TrainingCourseController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $isManager = $user->hasRole('Admin') || $user->hasRole('HR');
        
        if ($isManager) {
            $query = TrainingCourse::query();
            if ($request->filled('search')) {
                $query->where('name', 'LIKE', "%{$request->search}%");
            }
            $courses = $query->latest()->paginate(10)->withQueryString();
            $employees = Employee::all();
        } else {
            $employee = $user->employee;
            if (!$employee) {
                $courses = collect([])->paginate(10);
            } else {
                $query = $employee->trainingCourses();
                if ($request->filled('search')) {
                    $query->where('name', 'LIKE', "%{$request->search}%");
                }
                $courses = $query->latest()->paginate(10)->withQueryString();
            }
            $employees = collect([]);
        }

        return view('training-courses.index', compact('courses', 'employees', 'isManager'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ], [
            'name.required' => 'Vui lòng nhập tên khóa đào tạo.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
        ]);

        TrainingCourse::create($validated);

        return redirect()->route('training-courses.index')->with('success', 'Đã tạo khóa đào tạo mới!');
    }

    public function update(Request $request, TrainingCourse $trainingCourse)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ], [
            'name.required' => 'Vui lòng nhập tên khóa đào tạo.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
        ]);

        $trainingCourse->update($validated);

        return redirect()->route('training-courses.index')->with('success', 'Cập nhật khóa đào tạo thành công!');
    }

    public function destroy(TrainingCourse $trainingCourse)
    {
        $trainingCourse->delete();
        return redirect()->route('training-courses.index')->with('success', 'Đã xóa khóa đào tạo.');
    }
}
