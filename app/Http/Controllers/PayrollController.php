<?php
namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use App\Models\Attendance;
use App\Notifications\PayrollIssued;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $isManager = $user->hasRole('Admin') || $user->hasRole('Accountant');
        
        $query = Payroll::with('employee');

        // Access Control: Regular employees only see their own payroll
        if (!$isManager) {
            $employeeId = $user->employee->id ?? -1;
            $query->where('employee_id', $employeeId);
        }

        if ($request->filled('search') && $isManager) {
            $search = $request->search;
            $query->whereHas('employee', function($q) use ($search) {
                $q->where('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('employee_code', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $payrolls = $query->latest('year')->latest('month')->paginate(10)->withQueryString();

        // Financial Summary for Accountants/Admins
        $totalBudget = 0;
        if ($isManager) {
            $totalBudget = $query->clone()->sum('net_salary');
        }

        return view('payroll.index', compact('payrolls', 'isManager', 'totalBudget'));
    }

    public function create()
    {
        $employees = Employee::with('position')->get();
        return view('payroll.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000',
            'basic_salary' => 'required|numeric',
            'allowance' => 'required|numeric',
            'bonus' => 'nullable|numeric',
            'deduction' => 'nullable|numeric',
        ], [
            'employee_id.required' => 'Vui lòng chọn nhân viên.',
            'month.required' => 'Vui lòng nhập tháng.',
            'year.required' => 'Vui lòng nhập năm.',
            'basic_salary.required' => 'Vui lòng nhập lương cơ bản.',
        ]);

        $net_salary = $validated['basic_salary'] + $validated['allowance'] + ($validated['bonus'] ?? 0) - ($validated['deduction'] ?? 0);
        $validated['net_salary'] = $net_salary;

        $payroll = Payroll::create($validated);

        // Notify the employee
        $employeeUser = $payroll->employee->user;
        if ($employeeUser) {
            $employeeUser->notify(new PayrollIssued($payroll));
        }

        return redirect()->route('payroll.index')->with('success', 'Đã tạo phiếu lương mới!');
    }

    public function show(Employee $employee)
    {
        $now = Carbon::now();
        $attendanceCount = Attendance::where('employee_id', $employee->id)
            ->whereMonth('date', $now->month)
            ->whereYear('date', $now->year)
            ->where('status', 'P')
            ->count();
            
        $totalSalary = ($employee->position->basic_salary ?? 0) + ($employee->position->allowance ?? 0);
        
        return view('payroll.show', compact('employee', 'attendanceCount', 'totalSalary'));
    }
}
