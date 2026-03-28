@extends('layouts.app')

@section('title', 'Thêm chức vụ')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('positions.index') }}" class="text-emerald-600 hover:text-emerald-800 font-bold flex items-center mb-4 transition-all">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
        </a>
        <h1 class="text-3xl font-bold text-slate-900">Tạo chức vụ mới</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
        <form action="{{ route('positions.store') }}" method="POST" class="p-8">
            @csrf
            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-700 mb-2">Tên chức vụ</label>
                <input type="text" name="name" required value="{{ old('name') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="VD: Kỹ sư phần mềm cao cấp">
                @error('name') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Lương cơ bản (VNĐ)</label>
                    <input type="number" name="basic_salary" required value="{{ old('basic_salary') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="0">
                    @error('basic_salary') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Phụ cấp (VNĐ)</label>
                    <input type="number" name="allowance" required value="{{ old('allowance') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="0">
                    @error('allowance') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-8 py-4 bg-emerald-600 text-white font-bold rounded-xl shadow-lg shadow-emerald-600/30 hover:bg-emerald-700 transform transition-all hover:-translate-y-1 active:scale-95">
                    Lưu chức vụ
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
