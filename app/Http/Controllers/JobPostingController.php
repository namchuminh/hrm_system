<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\Department;
use Illuminate\Http\Request;

class JobPostingController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPosting::with('department');

        if ($request->filled('search')) {
            $query->where('title', 'LIKE', "%{$request->search}%");
        }

        if ($request->filled('dept_id')) {
            $query->where('department_id', $request->dept_id);
        }

        $jobPostings = $query->paginate(10)->withQueryString();
        $departments = Department::all();

        return view('job-postings.index', compact('jobPostings', 'departments'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('job-postings.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'department_id' => 'required|exists:departments,id',
            'quantity' => 'required|integer|min:1',
            'deadline' => 'nullable|date',
            'experience_required' => 'nullable|max:255',
            'salary_range' => 'nullable|max:255',
        ]);

        JobPosting::create($validated);

        return redirect()->route('job-postings.index')->with('success', 'Đã đăng tin tuyển dụng mới!');
    }

    public function edit(JobPosting $jobPosting)
    {
        $departments = Department::all();
        return view('job-postings.edit', compact('jobPosting', 'departments'));
    }

    public function update(Request $request, JobPosting $jobPosting)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'department_id' => 'required|exists:departments,id',
            'quantity' => 'required|integer|min:1',
            'deadline' => 'nullable|date',
            'experience_required' => 'nullable|max:255',
            'salary_range' => 'nullable|max:255',
        ]);

        $jobPosting->update($validated);

        return redirect()->route('job-postings.index')->with('success', 'Cập nhật tin tuyển dụng thành công!');
    }

    public function destroy(JobPosting $jobPosting)
    {
        $jobPosting->delete();
        return redirect()->route('job-postings.index')->with('success', 'Đã xóa tin tuyển dụng.');
    }
}
