@extends('layouts.app')

@section('title', 'Tạo đơn nghỉ phép')

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('leave-requests.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-bold mb-2 transition-all group">
                <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i> Quay lại danh sách
            </a>
            <h1 class="text-3xl font-black text-slate-900">Đơn xin nghỉ phép</h1>
            <p class="text-slate-500 font-medium">Vui lòng điền đầy đủ thông tin bên dưới.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-8 p-6 bg-rose-50 border-l-4 border-rose-500 text-rose-700 rounded-r-2xl shadow-sm">
            <h4 class="font-bold mb-2 uppercase text-xs tracking-widest">Phát hiện lỗi nhập liệu:</h4>
            <ul class="list-disc list-inside text-sm space-y-1 font-medium">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('leave-requests.store') }}" method="POST" class="space-y-8">
        @csrf
        
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-900 flex items-center uppercase text-sm tracking-widest">
                    <i class="fas fa-calendar-alt mr-3 text-indigo-600 text-lg"></i> Thông tin nghỉ phép
                </h3>
            </div>
            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Nhân viên nghỉ phép <span class="text-rose-500">*</span></label>
                        @if($employees->count() === 1)
                            <div class="px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-slate-600 font-bold flex items-center">
                                <i class="fas fa-user-lock mr-2 text-slate-400"></i>
                                {{ $employees->first()->full_name }} ({{ $employees->first()->employee_code }})
                                <input type="hidden" name="employee_id" value="{{ $employees->first()->id }}">
                            </div>
                        @else
                            <select name="employee_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none font-medium text-sm">
                                <option value="">-- Chọn nhân viên --</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->full_name }} ({{ $emp->employee_code }})</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Loại nghỉ phép <span class="text-rose-500">*</span></label>
                        <select name="leave_type_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none font-medium">
                            <option value="">-- Chọn loại nghỉ --</option>
                            @foreach($leaveTypes as $type)
                                <option value="{{ $type->id }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1 text-[10px] uppercase tracking-tighter">Ngày bắt đầu</label>
                        <input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1 text-[10px] uppercase tracking-tighter">Ngày kết thúc</label>
                        <input type="date" name="end_date" value="{{ old('end_date', date('Y-m-d')) }}" required 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Lý do nghỉ phép <span class="text-rose-500">*</span></label>
                    <textarea name="reason" rows="4" required 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none" 
                        placeholder="Mô tả chi tiết lý do nghỉ phép...">{{ old('reason') }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4 pt-4">
            <button type="reset" class="px-8 py-4 bg-white border border-slate-200 text-slate-600 font-extrabold rounded-2xl hover:bg-slate-50 transition-all active:scale-95 text-sm">
                XÓA NHẬP LẠI
            </button>
            <button type="submit" class="px-12 py-4 bg-indigo-600 text-white font-extrabold rounded-2xl shadow-xl shadow-indigo-600/30 hover:bg-indigo-700 transform transition-all active:scale-95 flex items-center text-sm uppercase tracking-widest">
                <i class="fas fa-paper-plane mr-2"></i> Gửi đơn nghỉ phép
            </button>
        </div>
    </form>
</div>
@endsection
