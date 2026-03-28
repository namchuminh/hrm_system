<?php
namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\JobPosting;
use App\Models\User;
use App\Notifications\CandidateStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        $query = Candidate::with('jobPosting');

        // Filtering by Job
        if ($request->filled('job_id')) {
            $query->where('job_id', $request->job_id);
        }

        // Filtering by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by Name/Email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $candidates = $query->latest()->paginate(10)->withQueryString();
        $jobPostings = JobPosting::all();

        return view('candidates.index', compact('candidates', 'jobPostings'));
    }

    public function create()
    {
        $jobPostings = JobPosting::all();
        return view('candidates.create', compact('jobPostings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_id' => 'required|exists:job_postings,id',
            'full_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|max:20',
            'experience' => 'nullable',
            'cv_path' => 'nullable',
        ]);

        $validated['status'] = 'Phỏng vấn';
        Candidate::create($validated);

        return redirect()->route('candidates.index')->with('success', 'Đã thêm ứng viên mới!');
    }

    public function update(Request $request, Candidate $candidate)
    {
        $request->validate([
            'status' => 'required|in:Phỏng vấn,Đạt,Loại'
        ]);

        $oldStatus = $candidate->status;
        $candidate->update(['status' => $request->status]);

        // Conversion Logic: Candidate -> Employee
        if ($request->status === 'Đạt' && $oldStatus !== 'Đạt') {
            return DB::transaction(function() use ($candidate) {
                // 1. Create User if not exists
                $user = User::where('email', $candidate->email)->first();
                if (!$user) {
                    $user = User::create([
                        'name' => $candidate->full_name,
                        'email' => $candidate->email,
                        'password' => Hash::make('12345678'), // Default password
                    ]);
                    
                    // Assign Employee Role
                    $role = \App\Models\Role::where('name', 'Employee')->first();
                    if ($role) {
                        $user->roles()->attach($role->id);
                    }
                }

                // 2. Create Employee Profile
                if (!$user->employee) {
                    $employeeCount = \App\Models\Employee::count() + 1;
                    $employeeCode = 'NV' . str_pad($employeeCount, 4, '0', STR_PAD_LEFT);
                    
                    $job = $candidate->jobPosting;
                    
                    $employee = \App\Models\Employee::create([
                        'user_id' => $user->id,
                        'full_name' => $candidate->full_name,
                        'employee_code' => $employeeCode,
                        'phone' => $candidate->phone,
                        'dept_id' => $job->department_id ?? null,
                        'join_date' => now(),
                        'status' => 'Đang làm',
                        'gender' => 'Nam', // Default
                    ]);

                    return redirect()->route('employees.edit', $employee->id)->with('success', 'Ứng viên đã được chuyển thành nhân viên mới! Vui lòng hoàn tất hồ sơ và ký hợp đồng.');
                }
                
                return back()->with('success', 'Cập nhật trạng thái thành công. Người dùng này đã có hồ sơ nhân viên.');
            });
        }

        // Notify Admins
        $admins = User::whereHas('roles', function($q) { $q->where('name', 'Admin'); })->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\CandidateStatusUpdated([
                'title' => 'Cập nhật trạng thái ứng viên',
                'message' => 'Ứng viên ' . $candidate->full_name . ' đã được chuyển sang trạng thái: ' . $candidate->status
            ]));
        }

        return back()->with('success', 'Đã cập nhật trạng thái ứng viên.');
    }

    public function destroy(Candidate $candidate)
    {
        $candidate->delete();
        return redirect()->route('candidates.index')->with('success', 'Đã xóa ứng viên.');
    }
}
