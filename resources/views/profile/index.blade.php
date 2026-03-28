@extends('layouts.app')

@section('title', 'Hồ sơ cá nhân')

@section('content')
<div class="max-w-6xl mx-auto pb-12">
    <div class="mb-10">
        <h1 class="text-4xl font-black text-slate-900 tracking-tight text-indigo-900">Thông tin cá nhân</h1>
        <p class="text-slate-500 font-medium mt-1 italic">Cập nhật hồ sơ và ảnh đại diện chuyên nghiệp của bạn.</p>
    </div>

    @if(session('success'))
        <div class="mb-8 p-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-2xl shadow-sm animate-fade-in flex items-center">
            <i class="fas fa-check-circle mr-3 text-xl"></i>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
        <!-- Sidebar Info -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-2xl shadow-slate-200/50 text-center relative overflow-hidden group">
                <div class="relative z-10">
                    <div class="w-32 h-32 mx-auto mb-6 relative">
                        <div class="w-full h-full rounded-[2rem] bg-indigo-50 border-4 border-white shadow-xl overflow-hidden flex items-center justify-center">
                            @if($employee && $employee->avatar)
                                <img src="{{ asset('storage/' . $employee->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-5xl font-black text-indigo-200 uppercase">{{ substr($user->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <div class="absolute -bottom-2 -right-2 bg-emerald-500 text-white w-8 h-8 rounded-full border-4 border-white flex items-center justify-center text-[10px] shadow-lg">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div>
                    <h2 class="text-2xl font-black text-slate-900 leading-tight">{{ $user->name }}</h2>
                    <p class="text-[10px] font-black uppercase tracking-widest text-indigo-500 mt-2 bg-indigo-50 px-4 py-1.5 rounded-full inline-block">
                        {{ $user->roles->first()->name ?? 'Nhân viên' }}
                    </p>
                </div>
                <!-- Decorative background -->
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-indigo-50 rounded-full opacity-50"></div>
                <div class="absolute -left-10 -bottom-10 w-24 h-24 bg-rose-50 rounded-full opacity-50"></div>
            </div>

            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-slate-900/40 relative overflow-hidden">
                <h3 class="font-black text-lg mb-4 flex items-center uppercase text-xs tracking-widest">
                    <i class="fas fa-fingerprint mr-2 text-indigo-400"></i> Bảo mật liên hệ
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center text-sm">
                        <i class="fas fa-envelope mr-3 text-slate-500"></i>
                        <span class="truncate opacity-80">{{ $user->email }}</span>
                    </div>
                    <div class="flex items-center text-sm">
                        <i class="fas fa-phone mr-3 text-slate-500"></i>
                        <span class="opacity-80">{{ $employee->phone ?? 'Chưa cập nhật' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl shadow-slate-200/30 overflow-hidden">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-slate-50">
                    @csrf @method('PUT')
                    
                    <!-- Avatar Upload -->
                    <div class="p-10 bg-slate-50/30">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-xs font-black uppercase tracking-widest text-slate-400">Thay đổi ảnh đại diện</h3>
                            <span class="text-[10px] text-slate-400 font-bold italic">* JPG, PNG (Max 2MB)</span>
                        </div>
                        <div class="flex items-center gap-8">
                            <div class="flex-shrink-0 w-20 h-20 rounded-2xl bg-white border-2 border-indigo-100 p-1">
                                @if($employee && $employee->avatar)
                                    <img src="{{ asset('storage/' . $employee->avatar) }}" class="w-full h-full object-cover rounded-xl">
                                @else
                                    <div class="w-full h-full bg-slate-50 flex items-center justify-center text-slate-300 rounded-xl">
                                        <i class="fas fa-user text-2xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow">
                                <input type="file" name="avatar" class="block w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="p-10 space-y-8">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xs font-black uppercase tracking-widest text-slate-400">Thông tin chi tiết</h3>
                            @if(!$isManager)
                                <span class="text-[10px] bg-amber-50 text-amber-600 px-3 py-1 rounded-full font-bold border border-amber-100 italic">
                                    <i class="fas fa-lock mr-1"></i> Một số trường chỉ HR/Admin mới có quyền chỉnh sửa
                                </span>
                            @endif
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Họ tên công tác <span class="text-rose-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:bg-white focus:border-indigo-500 transition-all outline-none font-bold text-slate-800 {{ !$isManager ? 'bg-slate-100 text-slate-500 cursor-not-allowed' : '' }}" {{ !$isManager ? 'readonly' : '' }}>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Địa chỉ Email <span class="text-rose-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:bg-white focus:border-indigo-500 transition-all outline-none font-bold text-slate-800 {{ !$isManager ? 'bg-slate-100 text-slate-500 cursor-not-allowed' : '' }}" {{ !$isManager ? 'readonly' : '' }}>
                            </div>
                            
                            <!-- Sensitive Fields (Locked for Employees) -->
                            <div class="relative">
                                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Ngày sinh</label>
                                <input type="date" name="dob" value="{{ old('dob', $employee->dob ?? '') }}" 
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:bg-white transition-all font-bold {{ !$isManager ? 'bg-slate-100 text-slate-500 cursor-not-allowed' : '' }}" {{ !$isManager ? 'readonly' : '' }}>
                                @if(!$isManager)<i class="fas fa-lock absolute right-4 top-[3.2rem] text-slate-300 text-xs"></i>@endif
                            </div>
                            <div class="relative">
                                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Nơi sinh / Quê quán</label>
                                <input type="text" name="pob" value="{{ old('pob', $employee->pob ?? '') }}" 
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:bg-white transition-all font-bold {{ !$isManager ? 'bg-slate-100 text-slate-500 cursor-not-allowed' : '' }}" {{ !$isManager ? 'readonly' : '' }}>
                                @if(!$isManager)<i class="fas fa-lock absolute right-4 top-[3.2rem] text-slate-300 text-xs"></i>@endif
                            </div>
                            
                            <div class="relative">
                                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Số CMND/CCCD</label>
                                <input type="text" name="identity_number" value="{{ old('identity_number', $employee->identity_number ?? '') }}" 
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:bg-white transition-all font-bold {{ !$isManager ? 'bg-slate-100 text-slate-500 cursor-not-allowed' : '' }}" {{ !$isManager ? 'readonly' : '' }}>
                                @if(!$isManager)<i class="fas fa-lock absolute right-4 top-[3.2rem] text-slate-300 text-xs"></i>@endif
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="relative">
                                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Ngày cấp</label>
                                    <input type="date" name="identity_date" value="{{ old('identity_date', $employee->identity_date ?? '') }}" 
                                        class="w-full px-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 transition-all font-bold {{ !$isManager ? 'bg-slate-100 text-slate-400' : '' }}" {{ !$isManager ? 'readonly' : '' }}>
                                </div>
                                <div class="relative">
                                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Nơi cấp</label>
                                    <input type="text" name="identity_place" value="{{ old('identity_place', $employee->identity_place ?? '') }}" 
                                        class="w-full px-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 transition-all font-bold {{ !$isManager ? 'bg-slate-100 text-slate-400' : '' }}" {{ !$isManager ? 'readonly' : '' }}>
                                </div>
                            </div>

                            <div class="relative">
                                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Mã số thuế cá nhân</label>
                                <input type="text" name="tax_code" value="{{ old('tax_code', $employee->tax_code ?? '') }}" 
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:bg-white transition-all font-bold {{ !$isManager ? 'bg-slate-100 text-slate-500 cursor-not-allowed' : '' }}" {{ !$isManager ? 'readonly' : '' }}>
                                @if(!$isManager)<i class="fas fa-lock absolute right-4 top-[3.2rem] text-slate-300 text-xs"></i>@endif
                            </div>
                            <div class="relative">
                                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Số sổ BHXH</label>
                                <input type="text" name="social_insurance_number" value="{{ old('social_insurance_number', $employee->social_insurance_number ?? '') }}" 
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:bg-white transition-all font-bold {{ !$isManager ? 'bg-slate-100 text-slate-500 cursor-not-allowed' : '' }}" {{ !$isManager ? 'readonly' : '' }}>
                                @if(!$isManager)<i class="fas fa-lock absolute right-4 top-[3.2rem] text-slate-300 text-xs"></i>@endif
                            </div>

                            <div class="group relative">
                                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Tài khoản ngân hàng</label>
                                <input type="text" name="bank_account" value="{{ old('bank_account', $employee->bank_account ?? '') }}" 
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:bg-white transition-all font-bold {{ !$isManager ? 'bg-slate-100 text-slate-500 cursor-not-allowed' : '' }}" {{ !$isManager ? 'readonly' : '' }}>
                                @if(!$isManager)<i class="fas fa-lock absolute right-4 top-[3.2rem] text-slate-300 text-xs"></i>@endif
                            </div>
                            <div class="relative">
                                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Ngân hàng thụ hưởng</label>
                                <input type="text" name="bank_name" value="{{ old('bank_name', $employee->bank_name ?? '') }}" 
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:bg-white transition-all font-bold {{ !$isManager ? 'bg-slate-100 text-slate-500 cursor-not-allowed' : '' }}" {{ !$isManager ? 'readonly' : '' }}>
                                @if(!$isManager)<i class="fas fa-lock absolute right-4 top-[3.2rem] text-slate-300 text-xs"></i>@endif
                            </div>

                            <div class="relative">
                                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Trình độ đào tạo</label>
                                <input type="text" name="education" value="{{ old('education', $employee->education ?? '') }}" 
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:bg-white transition-all font-bold {{ !$isManager ? 'bg-slate-100 text-slate-500 cursor-not-allowed' : '' }}" {{ !$isManager ? 'readonly' : '' }}>
                                @if(!$isManager)<i class="fas fa-lock absolute right-4 top-[3.2rem] text-slate-300 text-xs"></i>@endif
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Giới tính</label>
                                <select name="gender" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:bg-white transition-all font-bold outline-none {{ !$isManager ? 'bg-slate-100 text-slate-500 cursor-not-allowed' : '' }}" {{ !$isManager ? 'disabled' : '' }}>
                                    <option value="Nam" {{ ($employee->gender ?? '') == 'Nam' ? 'selected' : '' }}>Nam</option>
                                    <option value="Nữ" {{ ($employee->gender ?? '') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                    <option value="Khác" {{ ($employee->gender ?? '') == 'Khác' ? 'selected' : '' }}>Khác</option>
                                </select>
                            </div>

                            <!-- Editable Fields (Open for Everyone) -->
                            <div class="md:col-span-2 py-4 border-t border-slate-50 mt-4">
                                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-400 mb-6">Thông tin liên hệ (Có thể tự cập nhật)</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Số điện thoại liên hệ</label>
                                        <input type="text" name="phone" value="{{ old('phone', $employee->phone ?? '') }}" 
                                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:bg-white transition-all font-bold shadow-sm" placeholder="09xx xxx xxx">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Địa chỉ thường trú</label>
                                        <input type="text" name="address" value="{{ old('address', $employee->address ?? '') }}" 
                                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:bg-white transition-all font-bold shadow-sm" placeholder="TP. Hồ Chí Minh, Việt Nam">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Password Update -->
                    <div class="p-10 space-y-8 bg-slate-50/30">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xs font-black uppercase tracking-widest text-slate-400">Bảo mật tài khoản</h3>
                             <button type="button" class="text-[10px] font-black uppercase text-rose-500 tracking-widest hover:underline" onclick="document.getElementById('password_section').classList.toggle('hidden')">Thay đổi mật khẩu</button>
                        </div>
                        <div id="password_section" class="grid grid-cols-1 gap-8 hidden">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Mật khẩu hiện tại</label>
                                <input type="password" name="current_password" 
                                    class="w-full px-5 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-rose-100 outline-none transition-all placeholder:text-slate-300" placeholder="Nhập để xác minh thay đổi">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Mật khẩu mới</label>
                                    <input type="password" name="new_password" 
                                        class="w-full px-5 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 outline-none transition-all placeholder:text-slate-300" placeholder="Tối thiểu 8 ký tự">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Xác nhận mật khẩu mới</label>
                                    <input type="password" name="new_password_confirmation" 
                                        class="w-full px-5 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 outline-none transition-all placeholder:text-slate-300" placeholder="Nhập lại mật khẩu mới">
                                </div>
                            </div>
                        </div>
                        <p class="text-[11px] text-slate-400 font-medium italic underline decoration-slate-200">* Lưu ý: Giữ trống các trường này nếu bạn không có nhu cầu đổi mật khẩu.</p>
                    </div>

                    <div class="p-10 bg-white flex justify-end">
                        <button type="submit" class="px-12 py-5 bg-indigo-600 text-white font-black rounded-2xl shadow-2xl shadow-indigo-600/40 hover:bg-indigo-700 hover:-translate-y-1 active:scale-95 transition-all flex items-center uppercase tracking-widest text-xs">
                            <i class="fas fa-save mr-2"></i> Lưu cập nhật hồ sơ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
