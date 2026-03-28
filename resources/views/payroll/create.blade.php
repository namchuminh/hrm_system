@extends('layouts.app')

@section('title', 'Tạo phiếu lương')

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('payroll.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-bold mb-2 transition-all group">
                <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i> Quay lại danh sách
            </a>
            <h1 class="text-3xl font-black text-slate-900">Tính lương nhân sự</h1>
            <p class="text-slate-500 font-medium">Khởi tạo phiếu lương định kỳ hàng tháng.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-8 p-6 bg-rose-50 border-l-4 border-rose-500 text-rose-700 rounded-r-2xl shadow-sm">
            <ul class="list-disc list-inside text-sm space-y-1 font-bold">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('payroll.store') }}" method="POST" class="space-y-8">
        @csrf
        
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-900 flex items-center uppercase text-sm tracking-widest">
                    <i class="fas fa-money-check-alt mr-3 text-indigo-600 text-lg"></i> Thông tin kỳ lương
                </h3>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Nhân viên <span class="text-rose-500">*</span></label>
                    <select name="employee_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                        <option value="">-- Chọn nhân viên --</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" 
                                data-basic="{{ $emp->position->basic_salary ?? 0 }}"
                                data-allowance="{{ $emp->position->allowance ?? 0 }}"
                                {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                                {{ $emp->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1 text-[10px] uppercase font-mono tracking-tighter">Tháng lương</label>
                    <select name="month" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ old('month', date('n')) == $m ? 'selected' : '' }}>Tháng {{ $m }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1 text-[10px] uppercase font-mono tracking-tighter">Năm</label>
                    <input type="number" name="year" value="{{ old('year', date('Y')) }}" required 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none font-bold">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-900 flex items-center uppercase text-sm tracking-widest">
                    <i class="fas fa-calculator mr-3 text-indigo-600 text-lg"></i> Thành phần lương
                </h3>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Lương cơ bản <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input type="number" name="basic_salary" value="{{ old('basic_salary') }}" required 
                            class="w-full pl-4 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none font-black text-indigo-600">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-[10px]">VNĐ</span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Phụ cấp <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input type="number" name="allowance" value="{{ old('allowance', 0) }}" required 
                            class="w-full pl-4 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none font-black text-emerald-600">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-[10px]">VNĐ</span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Thưởng (Nếu có)</label>
                    <input type="number" name="bonus" value="{{ old('bonus', 0) }}" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Khấu trừ / Phạt</label>
                    <input type="number" name="deduction" value="{{ old('deduction', 0) }}" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all outline-none text-rose-600">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4 pt-4">
            <button type="submit" class="px-12 py-4 bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-600/30 hover:bg-indigo-700 transform transition-all active:scale-95 flex items-center uppercase tracking-widest text-sm">
                <i class="fas fa-check-double mr-2"></i> Xác nhận & Lưu phiếu lương
            </button>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const employeeSelect = document.querySelector('select[name="employee_id"]');
    const basicSalaryInput = document.querySelector('input[name="basic_salary"]');
    const allowanceInput = document.querySelector('input[name="allowance"]');

    employeeSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (selectedOption.value) {
            const basic = selectedOption.getAttribute('data-basic');
            const allowance = selectedOption.getAttribute('data-allowance');
            
            basicSalaryInput.value = basic;
            allowanceInput.value = allowance;
        } else {
            basicSalaryInput.value = '';
            allowanceInput.value = '0';
        }
    });
});
</script>
@endsection
