<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Permissions
        $permissions = ['manage_employees', 'manage_departments', 'view_payroll', 'manage_recruitment'];
        foreach ($permissions as $p) {
            \App\Models\Permission::firstOrCreate(['name' => $p]);
        }

        // 2. Roles
        $adminRole = \App\Models\Role::firstOrCreate(['name' => 'Admin']);
        $managerRole = \App\Models\Role::firstOrCreate(['name' => 'Manager']);
        $employeeRole = \App\Models\Role::firstOrCreate(['name' => 'Employee']);
        $adminRole->permissions()->sync(\App\Models\Permission::all());

        // 3. Departments
        $depts = [
            ['name' => 'Phòng Nhân sự', 'code' => 'HR', 'description' => 'Quản lý nhân sự và tuyển dụng'],
            ['name' => 'Phòng Kỹ thuật', 'code' => 'TECH', 'description' => 'Phát triển phần mềm và hạ tầng'],
            ['name' => 'Phòng Kinh doanh', 'code' => 'SALES', 'description' => 'Kinh doanh và tiếp thị'],
        ];
        foreach ($depts as $d) {
            \App\Models\Department::firstOrCreate(['code' => $d['code']], $d);
        }
        $hrDept = \App\Models\Department::where('code', 'HR')->first();

        // 4. Positions
        $positions = [
            ['name' => 'Trưởng phòng Nhân sự', 'basic_salary' => 25000000, 'allowance' => 5000000],
            ['name' => 'Nhân viên Kỹ thuật', 'basic_salary' => 15000000, 'allowance' => 2000000],
            ['name' => 'Chuyên viên Tuyển dụng', 'basic_salary' => 12000000, 'allowance' => 1000000],
        ];
        foreach ($positions as $p) {
            \App\Models\Position::firstOrCreate(['name' => $p['name']], $p);
        }
        $hrPos = \App\Models\Position::where('name', 'Chuyên viên Tuyển dụng')->first();

        // 5. Users & Employees
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@hrm.com'],
            ['name' => 'Quản trị viên', 'password' => \Illuminate\Support\Facades\Hash::make('password')]
        );
        $admin->roles()->sync([$adminRole->id]);

        $emp1 = \App\Models\Employee::firstOrCreate(
            ['employee_code' => 'NV001'],
            [
                'user_id' => $admin->id,
                'dept_id' => $hrDept->id,
                'pos_id' => $hrPos->id,
                'full_name' => 'Nguyễn Văn Admin',
                'gender' => 'Nam',
                'status' => 'Đang làm',
                'join_date' => now()->subYear(),
            ]
        );

        // 6. Job Postings
        $job = \App\Models\JobPosting::firstOrCreate(
            ['title' => 'Lập trình viên Laravel Senior'],
            [
                'description' => 'Phát triển các hệ thống quản trị nội bộ.',
                'quantity' => 2,
                'deadline' => now()->addMonth(),
            ]
        );

        // 7. Candidates
        \App\Models\Candidate::firstOrCreate(
            ['email' => 'candidate1@gmail.com'],
            [
                'job_id' => $job->id,
                'full_name' => 'Trần Thị Ứng Viên',
                'status' => 'Phỏng vấn',
            ]
        );

        // 8. Attendance (Today)
        \App\Models\Attendance::firstOrCreate(
            ['employee_id' => $emp1->id, 'date' => now()->toDateString()],
            [
                'check_in' => now()->startOfDay()->addHours(8),
                'ip_address' => '127.0.0.1',
                'status' => 'P',
            ]
        );

        // 9. Leave Types
        $annualLeave = \App\Models\LeaveType::firstOrCreate(['name' => 'Nghỉ phép năm'], ['days_allowed' => 12]);
        \App\Models\LeaveType::firstOrCreate(['name' => 'Nghỉ ốm'], ['days_allowed' => 5]);

        // 10. Leave Requests
        \App\Models\LeaveRequest::firstOrCreate(
            ['employee_id' => $emp1->id, 'reason' => 'Nghỉ gia đình'],
            [
                'leave_type_id' => $annualLeave->id,
                'start_date' => now()->addDays(5),
                'end_date' => now()->addDays(6),
                'status' => 'Chờ duyệt',
            ]
        );
    }
}
