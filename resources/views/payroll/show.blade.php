@extends('layouts.app')

@section('title', 'Phiếu lương - ' . $employee->full_name)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <a href="{{ route('payroll.index') }}" class="text-indigo-600 hover:text-indigo-800 font-bold flex items-center mb-2 transition-all">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại
            </a>
            <h1 class="text-3xl font-bold text-slate-900">Phiếu lương nhân viên</h1>
        </div>
        <button onclick="window.print()" class="px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition-all flex items-center print:hidden">
            <i class="fas fa-print mr-2"></i> In phiếu lương
        </button>
    </div>

    <!-- Payslip Document Style -->
    <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all hover:scale-[1.01]">
        <div class="p-12 border-b-8 border-indigo-600">
            <div class="flex justify-between items-start mb-12">
                <div>
                    <h2 class="text-3xl font-black text-indigo-600 mb-2 tracking-tighter">HRM <span class="text-slate-900">PRO</span></h2>
                    <p class="text-slate-400 text-sm font-medium">Giải pháp nơi làm việc kỹ thuật số</p>
                </div>
                <div class="text-right">
                    <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Kỳ thanh toán</div>
                    <div class="text-xl font-bold text-slate-900">Tháng {{ \Carbon\Carbon::now()->format('m/Y') }}</div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-12 mb-12">
                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Thông tin nhân viên</h4>
                    <div class="space-y-2">
                        <div class="font-bold text-xl text-slate-900">{{ $employee->full_name }}</div>
                        <div class="text-indigo-600 font-bold text-sm tracking-tight">{{ $employee->employee_code }}</div>
                        <div class="text-slate-500 text-sm italic">{{ $employee->position->name }} • {{ $employee->department->name }}</div>
                    </div>
                </div>
                <div class="text-right">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Tổng hợp chấm công</h4>
                    <div class="inline-flex flex-col items-end">
                        <span class="text-sm font-medium text-slate-500">Số ngày có mặt</span>
                        <span class="text-3xl font-black text-slate-900">{{ $attendanceCount }} <span class="text-sm font-normal text-slate-400">/ 22</span></span>
                    </div>
                </div>
            </div>

            <div class="bg-slate-50 rounded-2xl p-8 mb-8 border border-slate-100">
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600 font-medium">Lương cơ bản tháng</span>
                        <span class="font-mono font-bold text-slate-900">{{ number_format($employee->position->basic_salary ?? 0, 0, ',', '.') }} đ</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600 font-medium">Phụ cấp chức vụ</span>
                        <span class="font-mono font-bold text-emerald-600">+{{ number_format($employee->position->allowance ?? 0, 0, ',', '.') }} đ</span>
                    </div>
                    <div class="pt-4 border-t border-slate-200 flex justify-between items-center">
                        <span class="text-slate-900 font-black uppercase text-xs tracking-widest">Tổng thu nhập</span>
                        <span class="text-3xl font-black text-indigo-600">{{ number_format($totalSalary, 0, ',', '.') }} đ</span>
                    </div>
                </div>
            </div>

            <div class="text-center text-slate-400 text-[10px] uppercase font-bold tracking-widest">
                Tài liệu được tạo tự động • Không cần chữ ký
            </div>
        </div>
    </div>
</div>
@endsection
