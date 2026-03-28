@extends('layouts.app')

@section('title', 'Thêm ứng viên')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('candidates.index') }}" class="text-emerald-600 hover:text-emerald-800 font-bold flex items-center mb-4 transition-all">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
        </a>
        <h1 class="text-3xl font-bold text-slate-900">Hồ sơ ứng viên mới</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <form action="{{ route('candidates.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Họ và tên</label>
                <input type="text" name="full_name" required value="{{ old('full_name') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="Tên ứng viên">
                @error('full_name') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" required value="{{ old('email') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none placeholder-slate-400" placeholder="email@vi-du.com">
                    @error('email') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Số điện thoại</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none placeholder-slate-400" placeholder="09xx xxx xxx">
                    @error('phone') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Ứng tuyển vị trí <span class="text-rose-500">*</span></label>
                <select name="job_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none font-bold">
                    <option value="">-- Chọn vị trí --</option>
                    @foreach($jobPostings as $job)
                        <option value="{{ $job->id }}">{{ $job->title }}</option>
                    @endforeach
                </select>
                @error('job_id') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Kinh nghiệm / Ghi chú</label>
                <textarea name="experience" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none placeholder-slate-400" placeholder="VD: 5 năm kinh nghiệm lập trình Laravel...">{{ old('experience') }}</textarea>
                @error('experience') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="px-12 py-4 bg-emerald-600 text-white font-bold rounded-xl shadow-lg hover:bg-emerald-700 transform transition-all active:scale-95">
                    Lưu hồ sơ
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
