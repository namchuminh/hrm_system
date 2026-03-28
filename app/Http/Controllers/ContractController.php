<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Employee;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $isManager = $user->hasRole('Admin') || $user->hasRole('HR') || $user->hasRole('Accountant');
        
        $query = Contract::with('employee');
        
        // Access Control: Non-HR/Admin see only their own contracts
        if (!$isManager) {
            $employeeId = $user->employee->id ?? -1;
            $query->where('employee_id', $employeeId);
        }

        if ($request->filled('search') && $isManager) {
            $search = $request->search;
            $query->whereHas('employee', function($q) use ($search) {
                $q->where('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('employee_code', 'LIKE', "%{$search}%");
            })->orWhere('contract_number', 'LIKE', "%{$search}%");
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $contracts = $query->latest()->paginate(10)->withQueryString();
        $employees = $isManager ? Employee::all() : collect([]);

        return view('contracts.index', compact('contracts', 'employees', 'isManager'));
    }

    public function show(Contract $contract)
    {
        $user = auth()->user();
        $isManager = $user->hasRole('Admin') || $user->hasRole('HR') || $user->hasRole('Accountant');
        
        // Access Control: Can only see own contract if not manager
        if (!$isManager && $contract->employee_id !== ($user->employee->id ?? -1)) {
            abort(403);
        }

        return view('contracts.show', compact('contract'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'contract_number' => 'required|unique:contracts|max:100',
            'type' => 'required|in:Thời hạn,Vô thời hạn',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'salary_amount' => 'nullable|numeric|min:0',
            'probation_salary' => 'nullable|numeric|min:0',
            'working_time' => 'nullable|string|max:255',
            'allowances_text' => 'nullable|string',
        ]);

        Contract::create($validated);

        return redirect()->back()->with('success', 'Đã tạo hợp đồng mới!');
    }

    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'contract_number' => 'required|max:100|unique:contracts,contract_number,' . $contract->id,
            'type' => 'required|in:Thời hạn,Vô thời hạn',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'salary_amount' => 'nullable|numeric|min:0',
            'probation_salary' => 'nullable|numeric|min:0',
            'working_time' => 'nullable|string|max:255',
            'allowances_text' => 'nullable|string',
        ]);

        $contract->update($validated);

        return redirect()->back()->with('success', 'Cập nhật hợp đồng thành công!');
    }

    public function destroy(Contract $contract)
    {
        $contract->delete();
        return redirect()->back()->with('success', 'Đã xóa hợp đồng.');
    }
}
