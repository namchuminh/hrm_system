<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with(['department', 'position', 'user']);

        // Advanced Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('employee_code', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Advanced Filtering
        if ($request->filled('dept_id')) {
            $query->where('dept_id', $request->dept_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('pos_id')) {
            $query->where('pos_id', $request->pos_id);
        }

        $employees = $query->latest()->paginate(10)->withQueryString();
        
        $departments = Department::all();
        $positions = Position::all();

        return view('employees.index', compact('employees', 'departments', 'positions'));
    }

    public function create()
    {
        $departments = Department::all();
        $positions = Position::all();
        $roles = Role::all();
        return view('employees.create', compact('departments', 'positions', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|max:255',
            'employee_code' => 'required|unique:employees|max:20',
            'email' => 'required|email|unique:users',
            'dept_id' => 'nullable|exists:departments,id',
            'pos_id' => 'nullable|exists:positions,id',
            'gender' => 'required|in:Nam,Nữ,Khác',
            'dob' => 'nullable|date',
            'phone' => 'nullable|max:20',
            'address' => 'nullable',
            'join_date' => 'nullable|date',
            'role_id' => 'required|exists:roles,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pob' => 'nullable|string|max:255',
            'identity_number' => 'nullable|string|max:50',
            'identity_date' => 'nullable|date',
            'identity_place' => 'nullable|string|max:255',
            'tax_code' => 'nullable|string|max:50',
            'social_insurance_number' => 'nullable|string|max:50',
            'bank_account' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
        ]);

        // Avatar handling
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        // Create user first
        $user = User::create([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => bcrypt('123456'), // Default password
        ]);

        // Assign role
        $user->roles()->attach($validated['role_id']);

        // Create employee record
        $employeeData = $validated;
        unset($employeeData['email']);
        unset($employeeData['role_id']);
        $employeeData['user_id'] = $user->id;
        $employeeData['status'] = 'Thử việc';
        $employeeData['avatar'] = $avatarPath;
        
        Employee::create($employeeData);

        return redirect()->route('employees.index')->with('success', 'Đã tạo hồ sơ nhân viên thành công!');
    }

    public function show(Employee $employee)
    {
        $employee->load(['department', 'position', 'user', 'contracts', 'educationHistories', 'trainingCourses']);
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $positions = Position::all();
        $roles = Role::all();
        return view('employees.edit', compact('employee', 'departments', 'positions', 'roles'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'full_name' => 'required|max:255',
            'dept_id' => 'nullable|exists:departments,id',
            'pos_id' => 'nullable|exists:positions,id',
            'gender' => 'required|in:Nam,Nữ,Khác',
            'dob' => 'nullable|date',
            'phone' => 'nullable|max:20',
            'address' => 'nullable',
            'join_date' => 'nullable|date',
            'status' => 'required|in:Đang làm,Nghỉ việc,Thử việc',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pob' => 'nullable|string|max:255',
            'identity_number' => 'nullable|string|max:50',
            'identity_date' => 'nullable|date',
            'identity_place' => 'nullable|string|max:255',
            'tax_code' => 'nullable|string|max:50',
            'social_insurance_number' => 'nullable|string|max:50',
            'bank_account' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
        ]);

        $employeeData = $validated;

        // Avatar handling
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($employee->avatar) {
                Storage::disk('public')->delete($employee->avatar);
            }
            $employeeData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $employee->update($employeeData);
        
        if ($employee->user) {
            $employee->user->update(['name' => $validated['full_name']]);
        }

        return redirect()->route('employees.index')->with('success', 'Cập nhật hồ sơ nhân viên thành công!');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->user) {
            $employee->user->delete();
        }
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Đã xóa nhân viên.');
    }
}
