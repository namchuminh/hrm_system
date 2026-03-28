<?php
namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\LeaveRequestCreated;
use App\Notifications\LeaveStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class LeaveRequestController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $isManager = $user->hasRole('Admin') || $user->hasRole('HR') || $user->hasRole('Manager');
        
        $query = LeaveRequest::with(['employee', 'leaveType']);

        // Access Control: Employee and Accountant only see their own requests
        if (!$isManager) {
            $employeeId = $user->employee->id ?? -1;
            $query->where('employee_id', $employeeId);
        }

        // Filtering by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtering by Employee (Search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('employee', function($q) use ($search) {
                $q->where('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('employee_code', 'LIKE', "%{$search}%");
            });
        }

        // Filtering by Date Range
        if ($request->filled('start_date')) {
            $query->where('start_date', '>=', $request->start_date);
        }

        $leaveRequests = $query->latest()->paginate(10)->withQueryString();

        return view('leave-requests.index', compact('leaveRequests'));
    }

    public function create()
    {
        $user = auth()->user();
        $isManager = $user->hasRole('Admin') || $user->hasRole('HR') || $user->hasRole('Manager');
        
        $leaveTypes = LeaveType::all();
        
        if ($isManager) {
            $employees = Employee::all();
        } else {
            $employees = Employee::where('id', $user->employee->id ?? -1)->get();
        }
        
        return view('leave-requests.create', compact('leaveTypes', 'employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required',
        ]);

        $validated['status'] = 'Chờ duyệt';
        $leaveRequest = LeaveRequest::create($validated);

        // Notify approvers (Admin, HR, Manager)
        $approvers = User::whereHas('roles', function($q) {
            $q->whereIn('name', ['Admin', 'HR', 'Manager']);
        })->get();

        if ($approvers->count() > 0) {
            Notification::send($approvers, new LeaveRequestCreated($leaveRequest->load('employee')));
        }

        return redirect()->route('leave-requests.index')->with('success', 'Đã gửi đơn xin nghỉ phép!');
    }

    public function approve(Request $request, LeaveRequest $leaveRequest)
    {
        $leaveRequest->update(['status' => 'Đồng ý']);
        
        // Notify the employee
        $employeeUser = $leaveRequest->employee->user;
        if ($employeeUser) {
            $employeeUser->notify(new LeaveStatusUpdated($leaveRequest));
        }

        return back()->with('success', 'Đã phê duyệt đơn nghỉ phép.');
    }

    public function reject(Request $request, LeaveRequest $leaveRequest)
    {
        $leaveRequest->update(['status' => 'Từ chối']);
        
        // Notify the employee
        $employeeUser = $leaveRequest->employee->user;
        if ($employeeUser) {
            $employeeUser->notify(new LeaveStatusUpdated($leaveRequest));
        }

        return back()->with('success', 'Đã từ chối đơn nghỉ phép.');
    }

    public function destroy(LeaveRequest $leaveRequest)
    {
        if ($leaveRequest->status !== 'Chờ duyệt') {
            return back()->with('error', 'Chỉ có thể xóa đơn đang ở trạng thái Chờ duyệt.');
        }

        $leaveRequest->delete();
        return back()->with('success', 'Đã xóa đơn nghỉ phép.');
    }
}
