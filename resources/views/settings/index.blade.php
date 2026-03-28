@extends('layouts.app')

@section('title', 'Cài đặt hệ thống')

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight text-indigo-900">Cài đặt hệ thống</h1>
        <p class="text-slate-500 font-medium">Quản lý thông tin doanh nghiệp và các cấu hình vận hành HRM.</p>
    </div>

    <form action="{{ route('settings.update') }}" method="POST">
        @csrf
        <div class="space-y-8">
            <!-- Company Information -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden animate-slide-up">
                <div class="p-8 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center text-xl mr-4 shadow-sm">
                            <i class="fas fa-building"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900 leading-tight">Thông tin Doanh nghiệp</h3>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Hồ sơ pháp lý cơ bản</p>
                        </div>
                    </div>
                </div>
                <div class="p-10 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-sm font-black text-slate-700 uppercase tracking-widest ml-1">Tên Công ty</label>
                            <input type="text" name="company_name" value="{{ $settings['company_name'] ?? '' }}" 
                                class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-slate-800"
                                placeholder="CÔNG TY TNHH PHÁT TRIỂN CÔNG NGHỆ HRM PRO">
                            @error('company_name') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-black text-slate-700 uppercase tracking-widest ml-1">Người đại diện (Giám đốc)</label>
                            <input type="text" name="director_name" value="{{ $settings['director_name'] ?? '' }}" 
                                class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-slate-800"
                                placeholder="VŨ ĐỨC LONG">
                            @error('director_name') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-black text-slate-700 uppercase tracking-widest ml-1">Địa chỉ trụ sở chính</label>
                        <textarea name="company_address" rows="2" 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-slate-800">{{ $settings['company_address'] ?? '' }}</textarea>
                        @error('company_address') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-sm font-black text-slate-700 uppercase tracking-widest ml-1">Số điện thoại liên hệ</label>
                            <input type="text" name="company_phone" value="{{ $settings['company_phone'] ?? '' }}" 
                                class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-slate-800">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-black text-slate-700 uppercase tracking-widest ml-1">Email hệ thống</label>
                            <input type="email" name="company_email" value="{{ $settings['company_email'] ?? '' }}" 
                                class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-slate-800">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Operational Settings -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden animate-slide-up delay-100">
                <div class="p-8 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center text-xl mr-4 shadow-sm">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900 leading-tight">Cấu hình Vận hành</h3>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Thông số mặc định hệ thống</p>
                        </div>
                    </div>
                </div>
                <div class="p-10 space-y-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-black text-slate-700 uppercase tracking-widest ml-1">Thời gian làm việc quy định (Hiển thị hợp đồng)</label>
                        <input type="text" name="default_working_time" value="{{ $settings['default_working_time'] ?? '' }}" 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-slate-800"
                            placeholder="08 giờ/ngày (48 giờ/tuần)">
                        @error('default_working_time') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        <p class="text-[10px] text-slate-400 font-bold italic mt-1 ml-1">Sẽ được sử dụng làm giá trị mặc định khi tạo mới hợp đồng lao động.</p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4">
                <button type="submit" class="px-10 py-5 bg-indigo-600 text-white font-black rounded-3xl shadow-2xl shadow-indigo-600/30 hover:bg-indigo-700 hover:-translate-y-1 active:scale-95 transition-all flex items-center text-sm uppercase tracking-widest">
                    <i class="fas fa-save mr-2"></i> LƯU CẤU HÌNH HỆ THỐNG
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
