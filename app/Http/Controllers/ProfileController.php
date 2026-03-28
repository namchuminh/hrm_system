<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $employee = $user->employee;
        $isManager = $user->hasRole('Admin') || $user->hasRole('HR');
        return view('profile.index', compact('user', 'employee', 'isManager'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $employee = $user->employee;
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:Nam,Nữ,Khác',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        // Update User
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
            }
            $user->password = Hash::make($request->new_password);
        }
        $user->save();

        // Update Employee
        if ($employee) {
            $isManager = $user->hasRole('Admin') || $user->hasRole('HR');
            
            $employeeData = [
                'full_name' => $isManager ? $validated['name'] : $employee->full_name,
                'phone' => $validated['phone'] ?? $employee->phone,
                'address' => $validated['address'] ?? $employee->address,
                'gender' => $isManager ? ($validated['gender'] ?? $employee->gender) : $employee->gender,
                'dob' => $isManager ? ($validated['dob'] ?? $employee->dob) : $employee->dob,
            ];

            // If manager, allow updating more fields if they were in the request
            if ($isManager) {
                $extraFields = ['pob', 'identity_number', 'identity_date', 'identity_place', 'tax_code', 'social_insurance_number', 'bank_account', 'bank_name', 'education'];
                foreach ($extraFields as $field) {
                    if ($request->has($field)) {
                        $employeeData[$field] = $request->input($field);
                    }
                }
            }

            if ($request->hasFile('avatar')) {
                // Delete old avatar
                if ($employee->avatar) {
                    Storage::disk('public')->delete($employee->avatar);
                }
                $path = $request->file('avatar')->store('avatars', 'public');
                $employeeData['avatar'] = $path;
            }

            $employee->update($employeeData);
        }

        return back()->with('success', 'Hồ sơ cá nhân đã được cập nhật thành công!');
    }
}
