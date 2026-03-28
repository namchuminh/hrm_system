@extends('layouts.app')

@section('title', 'Chỉnh sửa nhân viên')

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('employees.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-bold mb-2 transition-all group">
                <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i> Quay lại danh sách
            </a>
            <h1 class="text-3xl font-black text-slate-900">Cập nhật hồ sơ nhân sự</h1>
            <p class="text-slate-500">Chỉnh sửa thông tin cho nhân viên: <span class="font-bold text-slate-700">{{ $employee->full_name }}</span></p>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-8 p-6 bg-rose-50 border-l-4 border-rose-500 text-rose-700 rounded-r-2xl shadow-sm">
            <h4 class="font-bold mb-2">Vui lòng kiểm tra lại các lỗi sau:</h4>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')
        
        <!-- Avatar & Basic -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-900 flex items-center uppercase text-sm tracking-widest">
                    <i class="fas fa-camera mr-3 text-indigo-600 text-lg"></i> Ảnh đại diện & Thông tin cơ bản
                </h3>
            </div>
            <div class="p-8 space-y-8">
                <div class="flex items-center gap-8">
                    <div class="w-24 h-24 rounded-2xl bg-slate-100 border-2 border-slate-100 overflow-hidden flex items-center justify-center shrink-0">
                        @if($employee->avatar)
                            <img src="{{ asset('storage/' . $employee->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-user text-3xl text-slate-300"></i>
                        @endif
                    </div>
                    <div class="flex-grow">
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Thay đổi ảnh đại diện</label>
                        <input type="file" name="avatar" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                        @error('avatar') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Họ và tên nhân viên <span class="text-rose-500">*</span></label>
                        <input type="text" name="full_name" value="{{ old('full_name', $employee->full_name) }}" required 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none" 
                            placeholder="VD: Nguyễn Văn A">
                        @error('full_name') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Giới tính <span class="text-rose-500">*</span></label>
                        <select name="gender" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                            <option value="Nam" {{ old('gender', $employee->gender) == 'Nam' ? 'selected' : '' }}>Nam</option>
                            <option value="Nữ" {{ old('gender', $employee->gender) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                            <option value="Khác" {{ old('gender', $employee->gender) == 'Khác' ? 'selected' : '' }}>Khác</option>
                        </select>
                        @error('gender') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Identity & Contact -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-900 flex items-center uppercase text-sm tracking-widest">
                    <i class="fas fa-id-card mr-3 text-indigo-600 text-lg"></i> Định danh & Liên hệ
                </h3>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Ngày sinh</label>
                    <input type="date" name="dob" value="{{ old('dob', $employee->dob) }}" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                    @error('dob') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Nơi sinh / Quê quán</label>
                    <input type="text" name="pob" value="{{ old('pob', $employee->pob) }}" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none" 
                        placeholder="VD: Hà Nội">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Số CMND / CCCD</label>
                    <input type="text" name="identity_number" value="{{ old('identity_number', $employee->identity_number) }}" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 mb-1 ml-1">Ngày cấp</label>
                        <input type="date" name="identity_date" value="{{ old('identity_date', $employee->identity_date) }}" 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 mb-1 ml-1">Nơi cấp</label>
                        <input type="text" name="identity_place" value="{{ old('identity_place', $employee->identity_place) }}" 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Số điện thoại</label>
                    <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none" 
                        placeholder="09xx xxx xxx">
                    @error('phone') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Trình độ đào tạo</label>
                    <input type="text" name="education" value="{{ old('education', $employee->education) }}" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none" 
                        placeholder="VD: Cử nhân Công nghệ thông tin">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Địa chỉ thường trú</label>
                    <textarea name="address" rows="2" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none" 
                        placeholder="Nhập địa chỉ đầy đủ...">{{ old('address', $employee->address) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Tax & Insurance & Bank -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-900 flex items-center uppercase text-sm tracking-widest">
                    <i class="fas fa-file-invoice-dollar mr-3 text-indigo-600 text-lg"></i> Tài chính & Bảo hiểm
                </h3>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Mã số thuế cá nhân</label>
                    <input type="text" name="tax_code" value="{{ old('tax_code', $employee->tax_code) }}" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Số sổ BHXH</label>
                    <input type="text" name="social_insurance_number" value="{{ old('social_insurance_number', $employee->social_insurance_number) }}" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Số tài khoản ngân hàng</label>
                    <input type="text" name="bank_account" value="{{ old('bank_account', $employee->bank_account) }}" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Tên ngân hàng</label>
                    <input type="text" name="bank_name" value="{{ old('bank_name', $employee->bank_name) }}" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all outline-none" 
                        placeholder="VD: Vietcombank - CN Hà Nội">
                </div>
            </div>
        </div>

        <!-- Employment Status -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-900 flex items-center uppercase text-sm tracking-widest">
                    <i class="fas fa-briefcase mr-3 text-indigo-600 text-lg"></i> Công tác
                </h3>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Mã nhân viên (Không thể sửa)</label>
                    <input type="text" value="{{ $employee->employee_code }}" disabled 
                        class="w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl cursor-not-allowed text-slate-500 font-bold outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Trạng thái làm việc <span class="text-rose-500">*</span></label>
                    <select name="status" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                        <option value="Đang làm" {{ old('status', $employee->status) == 'Đang làm' ? 'selected' : '' }}>Đang làm việc</option>
                        <option value="Thử việc" {{ old('status', $employee->status) == 'Thử việc' ? 'selected' : '' }}>Đang thử việc</option>
                        <option value="Nghỉ việc" {{ old('status', $employee->status) == 'Nghỉ việc' ? 'selected' : '' }}>Đã nghỉ việc</option>
                    </select>
                    @error('status') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Phòng ban</label>
                    <select name="dept_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                        <option value="">-- Chọn phòng ban --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('dept_id', $employee->dept_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Chức vụ</label>
                    <select name="pos_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                        <option value="">-- Chọn chức vụ --</option>
                        @foreach($positions as $pos)
                            <option value="{{ $pos->id }}" {{ old('pos_id', $employee->pos_id) == $pos->id ? 'selected' : '' }}>{{ $pos->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Ngày bắt đầu làm việc</label>
                    <input type="date" name="join_date" value="{{ old('join_date', $employee->join_date) }}" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4 pt-4">
            <a href="{{ route('employees.index') }}" class="px-8 py-4 bg-white border border-slate-200 text-slate-600 font-extrabold rounded-2xl hover:bg-slate-50 transition-all active:scale-95 text-center">
                HỦY BỎ
            </a>
            <button type="submit" class="px-12 py-4 bg-indigo-600 text-white font-extrabold rounded-2xl shadow-xl shadow-indigo-600/30 hover:bg-indigo-700 transform transition-all active:scale-95 flex items-center">
                <i class="fas fa-save mr-2"></i> LƯU THAY ĐỔI
            </button>
        </div>
    </form>
</div>
@endsection
