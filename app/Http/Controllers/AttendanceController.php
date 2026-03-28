<?php
namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $employee = $user->employee;
        
        if (!$employee && !$user->hasRole('Admin')) {
            return back()->with('error', 'Tài khoản này chưa được liên kết với hồ sơ nhân viên.');
        }

        $isManager = $user->hasRole('Admin') || $user->hasRole('HR') || $user->hasRole('Accountant') || $user->hasRole('Manager');
        
        $query = Attendance::with('employee');

        // Access Control: Regular employees only see their own attendance
        if (!$isManager) {
            $query->where('employee_id', $employee->id);
        }

        // Filtering by Employee (Only for Managers)
        if ($isManager && $request->filled('search')) {
            $search = $request->search;
            $query->whereHas('employee', function($q) use ($search) {
                $q->where('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('employee_code', 'LIKE', "%{$search}%");
            });
        }

        // Filtering by Date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $attendances = $query->latest('date')->latest('check_in')->paginate(15)->withQueryString();

        // Monthly Summary Logic
        $targetDate = $request->filled('date') ? Carbon::parse($request->date) : Carbon::now();
        $month = $request->input('month', $targetDate->month);
        $year = $request->input('year', $targetDate->year);
        $departmentId = $request->input('department_id');

        if ($isManager) {
            // Summary for all employees with optional department filter
            $summaryQuery = Attendance::select('employee_id', DB::raw('count(*) as total_days'))
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->whereIn('status', ['P', 'M'])
                ->groupBy('employee_id')
                ->with('employee.department');

            if ($departmentId) {
                $summaryQuery->whereHas('employee', function($q) use ($departmentId) {
                    $q->where('dept_id', $departmentId);
                });
            }

            $summary = $summaryQuery->get();
        } else {
            // Summary for current employee only
            $totalDays = Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->whereIn('status', ['P', 'M'])
                ->count();
            
            $summary = collect([
                (object)[
                    'employee' => $employee,
                    'total_days' => $totalDays
                ]
            ]);
        }

        $departments = \App\Models\Department::all();

        return view('attendance.index', compact('attendances', 'isManager', 'summary', 'targetDate', 'month', 'year', 'departmentId', 'departments'));
    }

    public function checkIn(Request $request)
    {
        $employee = Auth::user()->employee;
        if (!$employee) {
            return back()->with('error', 'Không tìm thấy hồ sơ nhân viên cho tài khoản này.');
        }

        $today = Carbon::today()->toDateString();
        $exists = Attendance::where('employee_id', $employee->id)
                            ->where('date', $today)
                            ->exists();

        if ($exists) {
            return back()->with('error', 'Bạn đã điểm danh hôm nay rồi.');
        }

        Attendance::create([
            'employee_id' => $employee->id,
            'date' => $today,
            'check_in' => Carbon::now(),
            'status' => 'P'
        ]);

        return back()->with('success', 'Điểm danh vào làm thành công!');
    }

    public function checkOut(Request $request)
    {
        $employee = Auth::user()->employee;
        if (!$employee) {
            return back()->with('error', 'Không tìm thấy hồ sơ nhân viên.');
        }

        $today = Carbon::today()->toDateString();
        $attendance = Attendance::where('employee_id', $employee->id)
                                ->where('date', $today)
                                ->whereNull('check_out')
                                ->first();

        if (!$attendance) {
            return back()->with('error', 'Bạn chưa điểm danh vào hoặc đã điểm danh ra rồi.');
        }

        $attendance->update([
            'check_out' => Carbon::now()
        ]);

        return back()->with('success', 'Điểm danh ra về thành công!');
    }
}
