<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // 1. Define Permissions
        $permissions = [
            'view_dashboard',
            'manage_employees',
            'manage_departments',
            'manage_positions',
            'manage_attendance',
            'view_own_attendance',
            'manage_leave',
            'view_own_leave',
            'approve_leave',
            'manage_recruitment',
            'manage_payroll',
            'view_own_payroll',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        // 2. Define Roles
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $hrRole = Role::firstOrCreate(['name' => 'HR']);
        $accountantRole = Role::firstOrCreate(['name' => 'Kế toán']);
        $managerRole = Role::firstOrCreate(['name' => 'Manager']);
        $employeeRole = Role::firstOrCreate(['name' => 'Employee']);

        // 3. Assign Permissions
        $adminRole->permissions()->sync(Permission::all());
        
        $hrRole->permissions()->sync(Permission::whereIn('name', [
            'view_dashboard', 'manage_employees', 'manage_departments', 
            'manage_positions', 'manage_recruitment', 'manage_attendance'
        ])->get());

        $accountantRole->permissions()->sync(Permission::whereIn('name', [
            'view_dashboard', 'manage_payroll', 'manage_attendance'
        ])->get());

        $employeeRole->permissions()->sync(Permission::whereIn('name', [
            'view_dashboard', 'view_own_attendance', 'view_own_leave', 'view_own_payroll'
        ])->get());

        // 4. Create Test Users
        $users = [
            ['email' => 'admin@hrm.com', 'name' => 'Quản trị viên', 'role' => 'Admin', 'code' => 'ADM'],
            ['email' => 'hr@hrm.com', 'name' => 'Nhân sự', 'role' => 'HR', 'code' => 'HRM'],
            ['email' => 'accountant@hrm.com', 'name' => 'Kế toán', 'role' => 'Kế toán', 'code' => 'ACC'],
            ['email' => 'employee@hrm.com', 'name' => 'Nhân viên mẫu', 'role' => 'Employee', 'code' => 'EMP'],
        ];

        foreach ($users as $u) {
            $user = User::updateOrCreate(
                ['email' => $u['email']],
                ['name' => $u['name'], 'password' => Hash::make('password')]
            );
            $role = Role::where('name', $u['role'])->first();
            $user->roles()->sync([$role->id]);
            
            // Create dummy employee record
            Employee::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'full_name' => $u['name'],
                    'employee_code' => 'NV_' . $u['code'] . rand(100, 999),
                    'gender' => 'Nam',
                    'status' => 'Đang làm'
                ]
            );
        }
    }
}
