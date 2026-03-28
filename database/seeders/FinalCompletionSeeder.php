<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Contract;
use App\Models\EducationHistory;
use App\Models\TrainingCourse;
use App\Models\EmployeeTraining;

class FinalCompletionSeeder extends Seeder
{
    public function run()
    {
        $employees = Employee::all();
        $roles = ['ADM', 'HRM', 'ACC', 'EMP'];

        foreach ($employees as $index => $emp) {
            // 1. Create Contracts
            Contract::firstOrCreate(
                ['employee_id' => $emp->id],
                [
                    'contract_number' => 'HĐ-' . now()->year . '-' . str_pad($emp->id, 3, '0', STR_PAD_LEFT),
                    'type' => $index % 2 == 0 ? 'Vô thời hạn' : 'Thời hạn',
                    'start_date' => $emp->join_date ?? now()->subMonths(6),
                    'end_date' => $index % 2 == 0 ? null : now()->addYear(),
                ]
            );

            // 2. Create Education
            EducationHistory::firstOrCreate(
                ['employee_id' => $emp->id, 'school' => 'Đại học Bách Khoa'],
                [
                    'major' => 'Công nghệ thông tin',
                    'degree' => 'Kỹ sư',
                    'year' => 2020 - $index,
                ]
            );
        }

        // 3. Create Training Courses
        $courses = [
            ['name' => 'Kỹ năng làm việc nhóm chuyên nghiệp', 'description' => 'Khóa huấn luyện kỹ năng mềm cho toàn hệ thống.'],
            ['name' => 'An toàn thông tin doanh nghiệp', 'description' => 'Hướng dẫn bảo mật dữ liệu nhân sự.'],
            ['name' => 'Quản trị nhân sự 4.0', 'description' => 'Cập nhật xu hướng quản trị hiện đại.'],
        ];

        foreach ($courses as $c) {
            $course = TrainingCourse::firstOrCreate(['name' => $c['name']], $c);
            
            // Link some employees to courses
            foreach ($employees->take(3) as $emp) {
                EmployeeTraining::firstOrCreate(
                    ['employee_id' => $emp->id, 'course_id' => $course->id],
                    ['result' => 'Xuất sắc']
                );
            }
        }
    }
}
