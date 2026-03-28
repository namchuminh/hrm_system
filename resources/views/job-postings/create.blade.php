@extends('layouts.app')

@section('title', 'Tạo tin tuyển dụng')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('job-postings.index') }}" class="text-indigo-600 hover:text-indigo-800 font-bold flex items-center mb-4 transition-all">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại
        </a>
        <h1 class="text-3xl font-bold text-slate-900">Tạo tin tuyển dụng mới</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <form action="{{ route('job-postings.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tiêu đề công việc</label>
                    <input type="text" name="title" required value="{{ old('title') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="VD: Lập trình viên Laravel Senior">
                    @error('title') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Số lượng tuyển</label>
                    <input type="number" name="quantity" required min="1" value="{{ old('quantity', 1) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none">
                    @error('quantity') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Hạn chót ứng tuyển</label>
                    <input type="date" name="deadline" value="{{ old('deadline') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none">
                    @error('deadline') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Phòng ban tuyển dụng <span class="text-rose-500">*</span></label>
                    <select name="department_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none font-bold">
                        <option value="">-- Chọn phòng ban --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Mô tả công việc</label>
                <textarea name="description" rows="5" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Trách nhiệm và công việc hàng ngày...">{{ old('description') }}</textarea>
                @error('description') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end pt-4"">
                <button type="submit" class="px-12 py-4 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 transform transition-all active:scale-95">
                    Đăng tin ngay
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
