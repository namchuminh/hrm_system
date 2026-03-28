@extends('layouts.app')

@section('title', 'Chỉnh sửa tin tuyển dụng')

@section('content')
<div class="max-w-3xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('job-postings.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-bold mb-2 transition-all group">
                <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i> Quay lại
            </a>
            <h1 class="text-3xl font-black text-slate-900">Cập nhật tin tuyển dụng</h1>
            <p class="text-slate-500 italic">ID: {{ $jobPosting->id }}</p>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-8 p-6 bg-rose-50 border-l-4 border-rose-500 text-rose-700 rounded-r-2xl shadow-sm">
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <form action="{{ route('job-postings.update', $jobPosting->id) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Tiêu đề tuyển dụng <span class="text-rose-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $jobPosting->title) }}" required 
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none" 
                    placeholder="VD: Senior PHP Developer">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Số lượng cần tuyển <span class="text-rose-500">*</span></label>
                    <input type="number" name="quantity" value="{{ old('quantity', $jobPosting->quantity) }}" required min="1"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                </div>
                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Hạn nộp hồ sơ</label>
                    <input type="date" name="deadline" value="{{ old('deadline', $jobPosting->deadline) }}" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                    @error('deadline') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Phòng ban tuyển dụng <span class="text-rose-500">*</span></label>
                    <select name="department_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none font-bold">
                        <option value="">-- Chọn phòng ban --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id', $jobPosting->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Mô tả công việc & Yêu cầu <span class="text-rose-500">*</span></label>
                <textarea name="description" rows="6" required
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none font-medium text-slate-700 leading-relaxed" 
                    placeholder="Chi tiết mô tả công việc, quyền lợi và yêu cầu ứng viên...">{{ old('description', $jobPosting->description) }}</textarea>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4">
                <button type="submit" class="px-12 py-4 bg-indigo-600 text-white font-extrabold rounded-2xl shadow-xl shadow-indigo-600/30 hover:bg-indigo-700 transform transition-all active:scale-95 flex items-center">
                    <i class="fas fa-save mr-2"></i> LƯU THAY ĐỔI
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
