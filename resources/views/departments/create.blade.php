@extends('layouts.app')

@section('title', 'Thêm phòng ban')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('departments.index') }}" class="text-indigo-600 hover:text-indigo-800 font-bold flex items-center mb-4 transition-all">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
        </a>
        <h1 class="text-3xl font-bold text-slate-900">Tạo phòng ban mới</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
        <form action="{{ route('departments.store') }}" method="POST" class="p-8">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tên phòng ban</label>
                    <input type="text" name="name" required value="{{ old('name') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all" placeholder="VD: Trung tâm Công nghệ">
                    @error('name') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Mã phòng ban</label>
                    <input type="text" name="code" required value="{{ old('code') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all" placeholder="VD: IT-DEPT">
                    @error('code') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-700 mb-2">Trưởng phòng (Tùy chọn)</label>
                <select name="manager_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none">
                    <option value="">-- Chọn trưởng phòng --</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ old('manager_id') == $emp->id ? 'selected' : '' }}>{{ $emp->full_name }} ({{ $emp->employee_code }})</option>
                    @endforeach
                </select>
                @error('manager_id') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-700 mb-2">Mô tả</label>
                <textarea name="description" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all" placeholder="Nhập mục tiêu và phạm vi của phòng ban...">{{ old('description') }}</textarea>
                @error('description') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-8 py-4 bg-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-600/30 hover:bg-indigo-700 transform transition-all hover:-translate-y-1 active:scale-95">
                    Lưu phòng ban
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
