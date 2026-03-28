<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::with('manager');

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', "%{$request->search}%")
                  ->orWhere('code', 'LIKE', "%{$request->search}%");
        }

        if ($request->filled('manager_id')) {
            $query->where('manager_id', $request->manager_id);
        }

        $departments = $query->paginate(10)->withQueryString();
        $managers = Employee::all();

        return view('departments.index', compact('departments', 'managers'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('departments.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:50|unique:departments',
            'description' => 'nullable',
            'manager_id' => 'nullable|exists:employees,id',
        ], [
            'name.required' => 'Vui lòng nhập tên phòng ban.',
            'code.required' => 'Vui lòng nhập mã phòng ban.',
            'code.unique' => 'Mã phòng ban này đã tồn tại trên hệ thống.',
        ]);

        Department::create($validated);

        return redirect()->route('departments.index')->with('success', 'Đã thêm phòng ban mới!');
    }

    public function edit(Department $department)
    {
        $employees = Employee::all();
        return view('departments.edit', compact('department', 'employees'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:50|unique:departments,code,' . $department->id,
            'description' => 'nullable',
            'manager_id' => 'nullable|exists:employees,id',
        ], [
            'name.required' => 'Vui lòng nhập tên phòng ban.',
            'code.required' => 'Vui lòng nhập mã phòng ban.',
            'code.unique' => 'Mã phòng ban này đã tồn tại trên hệ thống.',
        ]);

        $department->update($validated);

        return redirect()->route('departments.index')->with('success', 'Cập nhật phòng ban thành công!');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Đã xóa phòng ban.');
    }
}
