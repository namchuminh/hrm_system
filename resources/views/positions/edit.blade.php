@extends('layouts.app')

@section('title', 'Chỉnh sửa chức vụ')

@section('content')
<div class="max-w-2xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('positions.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-bold mb-2 transition-all group">
                <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i> Quay lại
            </a>
            <h1 class="text-3xl font-black text-slate-900">Cập nhật chức vụ</h1>
            <p class="text-slate-500 italic">Đang chỉnh sửa: {{ $position->name }}</p>
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
        <form action="{{ route('positions.update', $position->id) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Tên chức vụ <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $position->name) }}" required 
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none" 
                    placeholder="VD: Lập trình viên Backend">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Lương cơ bản (VNĐ)</label>
                    <input type="number" name="basic_salary" value="{{ old('basic_salary', $position->basic_salary) }}" required 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none" 
                        placeholder="0">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Phụ cấp (VNĐ)</label>
                    <input type="number" name="allowance" value="{{ old('allowance', $position->allowance) }}" required 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none" 
                        placeholder="0">
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4">
                <button type="submit" class="px-12 py-4 bg-indigo-600 text-white font-extrabold rounded-2xl shadow-xl shadow-indigo-600/30 hover:bg-indigo-700 transform transition-all active:scale-95 flex items-center">
                    <i class="fas fa-save mr-2"></i> CẬP NHẬT CHỨC VỤ
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
