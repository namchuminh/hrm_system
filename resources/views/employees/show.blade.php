@extends('layouts.app')

@section('title', 'Hồ sơ nhân viên: ' . $employee->full_name)

@section('content')
<div class="max-w-6xl mx-auto pb-12">
    <!-- Breadcrumb & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <a href="{{ route('employees.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-bold mb-2 transition-all group">
                <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i> Quay lại danh sách
            </a>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight">{{ $employee->full_name }}</h1>
            <div class="flex items-center mt-2 space-x-4">
                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-black uppercase rounded-lg border border-indigo-100">
                    {{ $employee->employee_code }}
                </span>
                <span class="px-3 py-1 {{ $employee->status == 'Đang làm' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-amber-50 text-amber-600 border-amber-100' }} text-xs font-black uppercase rounded-lg border">
                    {{ $employee->status }}
                </span>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('employees.edit', $employee) }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-extrabold rounded-2xl hover:bg-slate-50 transition-all shadow-sm">
                <i class="fas fa-edit mr-2"></i> CHỈNH SỬA HỒ SƠ
            </a>
            <button class="px-6 py-3 bg-indigo-600 text-white font-extrabold rounded-2xl shadow-xl shadow-indigo-600/20 hover:bg-indigo-700 transition-all flex items-center">
                <i class="fas fa-print mr-2"></i> XUẤT PDF
            </button>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="flex border-b border-slate-100 overflow-x-auto whitespace-nowrap bg-slate-50/50">
            <button onclick="switchTab('profile')" id="tab-profile" class="tab-btn px-8 py-5 font-black text-sm uppercase tracking-widest border-b-2 transition-all border-indigo-600 text-indigo-600">
                <i class="fas fa-id-card mr-2"></i> Thông tin cơ bản
            </button>
            <button onclick="switchTab('contracts')" id="tab-contracts" class="tab-btn px-8 py-5 font-black text-sm uppercase tracking-widest border-b-2 transition-all border-transparent text-slate-400 hover:text-slate-600">
                <i class="fas fa-file-contract mr-2"></i> Hợp đồng ({{ $employee->contracts->count() }})
            </button>
            <button onclick="switchTab('education')" id="tab-education" class="tab-btn px-8 py-5 font-black text-sm uppercase tracking-widest border-b-2 transition-all border-transparent text-slate-400 hover:text-slate-600">
                <i class="fas fa-graduation-cap mr-2"></i> Học vấn ({{ $employee->educationHistories->count() }})
            </button>
            <button onclick="switchTab('training')" id="tab-training" class="tab-btn px-8 py-5 font-black text-sm uppercase tracking-widest border-b-2 transition-all border-transparent text-slate-400 hover:text-slate-600">
                <i class="fas fa-certificate mr-2"></i> Đào tạo ({{ $employee->trainingCourses->count() }})
            </button>
        </div>

        <div class="p-8">
             <!-- Profile Tab -->
            <div id="content-profile" class="tab-content space-y-10 animate-fade-in text-slate-700">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                    <div class="md:col-span-1 space-y-6">
                        <div class="aspect-square bg-slate-50 rounded-[2.5rem] border-4 border-white shadow-2xl shadow-indigo-500/10 flex items-center justify-center text-slate-200 relative overflow-hidden group">
                           @if($employee->avatar)
                               <img src="{{ asset('storage/' . $employee->avatar) }}" class="w-full h-full object-cover">
                           @else
                               <i class="fas fa-user text-6xl transition-transform group-hover:scale-110"></i>
                           @endif
                        </div>
                        
                        <div class="p-6 bg-slate-900 rounded-3xl text-white shadow-xl">
                            <h4 class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-4">Liên hệ nhanh</h4>
                            <div class="space-y-4">
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-envelope mr-3 text-slate-500"></i>
                                    <span class="truncate opacity-80">{{ $employee->user->email ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-phone mr-3 text-slate-500"></i>
                                    <span class="opacity-80">{{ $employee->phone ?? 'Chưa cập nhật' }}</span>
                                </div>
                                <div class="flex items-start text-sm">
                                    <i class="fas fa-map-marker-alt mr-3 text-slate-500 mt-1"></i>
                                    <span class="opacity-80 leading-relaxed">{{ $employee->address ?? 'Chưa cập nhật' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="md:col-span-3 space-y-12">
                        <!-- Basic Info Section -->
                        <section>
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] flex items-center">
                                    <i class="fas fa-info-circle mr-2 text-indigo-600"></i> Thông tin cơ bản
                                </h3>
                                <div class="h-px flex-grow bg-slate-100 ml-4"></div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Phòng ban</label>
                                    <p class="text-base font-bold text-slate-800">{{ $employee->department->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Chức vụ</label>
                                    <p class="text-base font-bold text-indigo-600">{{ $employee->position->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Ngày vào làm</label>
                                    <p class="text-base font-bold text-slate-800">{{ $employee->join_date ? date('d/m/Y', strtotime($employee->join_date)) : 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Giới tính</label>
                                    <p class="text-base font-bold text-slate-800">{{ $employee->gender }}</p>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Ngày sinh</label>
                                    <p class="text-base font-bold text-slate-800">{{ $employee->dob ? date('d/m/Y', strtotime($employee->dob)) : 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Nơi sinh / Quê quán</label>
                                    <p class="text-base font-bold text-slate-800">{{ $employee->pob ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </section>

                        <!-- Identity & Finance Section -->
                        <section>
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] flex items-center">
                                    <i class="fas fa-file-invoice-dollar mr-2 text-indigo-600"></i> Định danh & Tài chính
                                </h3>
                                <div class="h-px flex-grow bg-slate-100 ml-4"></div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Số CMND / CCCD</label>
                                    <p class="text-base font-bold text-slate-800 tracking-widest">{{ $employee->identity_number ?? 'N/A' }}</p>
                                    @if($employee->identity_date)
                                    <p class="text-[10px] text-slate-400 mt-1 font-bold">Cấp ngày: {{ date('d/m/Y', strtotime($employee->identity_date)) }} - {{ $employee->identity_place }}</p>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Mã số thuế</label>
                                    <p class="text-base font-bold text-slate-800">{{ $employee->tax_code ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Số sổ BHXH</label>
                                    <p class="text-base font-bold text-slate-800">{{ $employee->social_insurance_number ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Tài khoản ngân hàng</label>
                                    <p class="text-base font-bold text-slate-800 tracking-widest">{{ $employee->bank_account ?? 'N/A' }}</p>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Ngân hàng thụ hưởng</label>
                                    <p class="text-base font-bold text-slate-800">{{ $employee->bank_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Trình độ đào tạo</label>
                                    <p class="text-base font-bold text-slate-800">{{ $employee->education ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>

            <!-- Contracts Tab -->
            <div id="content-contracts" class="tab-content hidden space-y-6 animate-fade-in">
                <div class="flex justify-between items-center bg-slate-50 p-6 rounded-3xl border border-slate-100">
                    <div>
                        <h4 class="font-black text-slate-900">Danh sách hợp đồng</h4>
                        <p class="text-xs text-slate-500 font-medium">Lịch sử ký kết hợp đồng lao động của nhân viên.</p>
                    </div>
                    @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('HR'))
                    <button onclick="document.getElementById('addContractModal').classList.remove('hidden')" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold text-xs hover:bg-indigo-700 transition-all flex items-center shadow-lg shadow-indigo-600/20">
                        <i class="fas fa-plus mr-2"></i> THÊM HỢP ĐỒNG
                    </button>
                    @endif
                </div>

                @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('HR'))
                <!-- Add Contract Modal -->
                <div id="addContractModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4">
                    <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden animate-slide-up max-h-[90vh] overflow-y-auto">
                        <form action="{{ route('contracts.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 sticky top-0 bg-white z-10">
                                <h3 class="text-xl font-black text-slate-900">Thêm Hợp đồng: <span class="text-indigo-600">{{ $employee->full_name }}</span></h3>
                                <button type="button" onclick="document.getElementById('addContractModal').classList.add('hidden')" class="text-slate-400 hover:text-rose-500 transition-colors"><i class="fas fa-times"></i></button>
                            </div>
                            <div class="p-8 space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Số hợp đồng <span class="text-rose-500">*</span></label>
                                        <input type="text" name="contract_number" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold uppercase tracking-widest" placeholder="HĐ-{{ date('Y') }}-{{ $employee->employee_code }}">
                                        @error('contract_number') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Loại hợp đồng <span class="text-rose-500">*</span></label>
                                        <select name="type" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold">
                                            <option value="Thời hạn">Có thời hạn</option>
                                            <option value="Vô thời hạn">Vô thời hạn</option>
                                        </select>
                                        @error('type') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Lương chính thức (VNĐ)</label>
                                        <input type="number" name="salary_amount" value="{{ $employee->position->basic_salary ?? 0 }}" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Thời gian làm việc</label>
                                        <input type="text" name="working_time" value="{{ \App\Models\SystemSetting::getSetting('default_working_time', '08 giờ/ngày (48 giờ/tuần)') }}" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Ngày bắt đầu <span class="text-rose-500">*</span></label>
                                        <input type="date" name="start_date" value="{{ date('Y-m-d') }}" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold">
                                        @error('start_date') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Ngày kết thúc</label>
                                        <input type="date" name="end_date" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold">
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex justify-end space-x-3 sticky bottom-0 bg-white">
                                <button type="button" onclick="document.getElementById('addContractModal').classList.add('hidden')" class="px-6 py-3 font-bold text-slate-500 hover:text-slate-700 transition-colors uppercase text-[10px] tracking-wider">Hủy bỏ</button>
                                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-black rounded-2xl shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 active:scale-95 transition-all text-xs uppercase tracking-widest">Ký kết hợp đồng</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                <th class="pb-4">Số HĐ</th>
                                <th class="pb-4">Loại</th>
                                <th class="pb-4">Ngày bắt đầu</th>
                                <th class="pb-4">Ngày kết thúc</th>
                                <th class="pb-4 text-right">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($employee->contracts as $contract)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 font-bold text-indigo-600 tracking-wider text-sm">{{ $contract->contract_number }}</td>
                                <td class="py-4 font-medium text-slate-600 text-sm">{{ $contract->type }}</td>
                                <td class="py-4 font-medium text-slate-500 text-sm">{{ date('d/m/Y', strtotime($contract->start_date)) }}</td>
                                <td class="py-4 font-medium text-slate-500 text-sm">{{ $contract->end_date ? date('d/m/Y', strtotime($contract->end_date)) : 'Vô thời hạn' }}</td>
                                <td class="py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('contracts.show', $contract->id) }}" class="p-2 text-indigo-600 hover:bg-white rounded-lg transition-all" title="Xem & In">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('HR'))
                                        <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST" class="inline" onsubmit="return confirm('Xác nhận xóa hợp đồng này?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition-all">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-20 text-center text-slate-400 font-bold italic">Chưa ghi nhận hợp đồng lao động nào.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Education Tab -->
            <div id="content-education" class="tab-content hidden space-y-6 animate-fade-in">
                <div class="flex justify-between items-center bg-slate-50 p-6 rounded-3xl border border-slate-100">
                    <div>
                        <h4 class="font-black text-slate-900">Lịch sử học tập</h4>
                        <p class="text-xs text-slate-500 font-medium">Thông tin về bằng cấp và trình độ chuyên môn.</p>
                    </div>
                    @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('HR'))
                    <button onclick="document.getElementById('addEduModal').classList.remove('hidden')" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold text-xs hover:bg-indigo-700 transition-all flex items-center shadow-lg shadow-indigo-600/20">
                        <i class="fas fa-plus mr-2"></i> THÊM HỌC VẤN
                    </button>
                    @endif
                </div>

                @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('HR'))
                <!-- Add Education Modal -->
                <div id="addEduModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[110] hidden flex items-center justify-center p-4">
                    <div class="bg-white w-full max-w-xl rounded-3xl shadow-2xl overflow-hidden animate-slide-up">
                        <form action="{{ route('education-histories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                                <h3 class="text-xl font-black text-slate-900">Thêm hồ sơ học vấn</h3>
                                <button type="button" onclick="document.getElementById('addEduModal').classList.add('hidden')" class="text-slate-400 hover:text-rose-500 transition-colors"><i class="fas fa-times"></i></button>
                            </div>
                            <div class="p-8 space-y-5">
                                <div class="space-y-2">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Trường học / Cơ sở đào tạo <span class="text-rose-500">*</span></label>
                                    <input type="text" name="school" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold">
                                    @error('school') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                                <div class="grid grid-cols-2 gap-5">
                                    <div class="space-y-2">
                                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Chuyên ngành <span class="text-rose-500">*</span></label>
                                        <input type="text" name="major" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold">
                                        @error('major') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Bằng cấp <span class="text-rose-500">*</span></label>
                                        <input type="text" name="degree" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold" placeholder="Cử nhân, Thạc sĩ...">
                                        @error('degree') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-5">
                                    <div class="space-y-2">
                                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Năm tốt nghiệp <span class="text-rose-500">*</span></label>
                                        <input type="number" name="year" required value="{{ date('Y') }}" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold">
                                        @error('year') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Bảng điểm / Bằng cấp (Ảnh)</label>
                                        <input type="file" name="transcript_image" accept="image/*" class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl outline-none text-xs">
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex justify-end space-x-3">
                                <button type="button" onclick="document.getElementById('addEduModal').classList.add('hidden')" class="px-6 py-3 font-bold text-slate-500 hover:text-slate-700 transition-colors uppercase text-[10px] tracking-wider">Hủy bỏ</button>
                                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-black rounded-2xl shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 transition-all text-xs uppercase tracking-widest">Lưu hồ sơ</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Education Modal -->
                <div id="editEduModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[110] hidden flex items-center justify-center p-4">
                    <div class="bg-white w-full max-w-xl rounded-3xl shadow-2xl overflow-hidden animate-slide-up">
                        <form id="editEduForm" method="POST" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                                <h3 class="text-xl font-black text-slate-900">Sửa hồ sơ học vấn</h3>
                                <button type="button" onclick="document.getElementById('editEduModal').classList.add('hidden')" class="text-slate-400 hover:text-rose-500 transition-colors"><i class="fas fa-times"></i></button>
                            </div>
                            <div class="p-8 space-y-5">
                                <div class="space-y-2">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Trường học / Cơ sở đào tạo <span class="text-rose-500">*</span></label>
                                    <input type="text" name="school" id="edit_edu_school" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold">
                                </div>
                                <div class="grid grid-cols-2 gap-5">
                                    <div class="space-y-2">
                                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Chuyên ngành <span class="text-rose-500">*</span></label>
                                        <input type="text" name="major" id="edit_edu_major" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Bằng cấp <span class="text-rose-500">*</span></label>
                                        <input type="text" name="degree" id="edit_edu_degree" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-5">
                                    <div class="space-y-2">
                                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Năm tốt nghiệp <span class="text-rose-500">*</span></label>
                                        <input type="number" name="year" id="edit_edu_year" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Thay đổi bảng điểm (Ảnh)</label>
                                        <input type="file" name="transcript_image" accept="image/*" class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl outline-none text-xs">
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex justify-end space-x-3">
                                <button type="button" onclick="document.getElementById('editEduModal').classList.add('hidden')" class="px-6 py-3 font-bold text-slate-500 hover:text-slate-700 transition-colors uppercase text-[10px] tracking-wider">Hủy bỏ</button>
                                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-black rounded-2xl shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 transition-all text-xs uppercase tracking-widest">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

                <!-- Simple list layout for education -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($employee->educationHistories as $edu)
                    <div class="p-6 bg-white border border-slate-200 rounded-3xl relative overflow-hidden group hover:border-indigo-200 transition-all shadow-sm hover:shadow-xl hover:shadow-indigo-500/5">
                        <div class="flex items-start">
                           <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-xl mr-4 flex-shrink-0">
                               <i class="fas fa-university"></i>
                           </div>
                           <div class="flex-grow">
                               <div class="flex justify-between items-start">
                                   <h5 class="font-black text-slate-900 line-clamp-1 pr-4">{{ $edu->school }}</h5>
                                   @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('HR'))
                                   <div class="flex space-x-1">
                                       <button onclick="openEditEduModal({{ json_encode($edu) }})" class="p-1.5 text-slate-400 hover:text-indigo-600 transition-colors"><i class="fas fa-edit text-xs"></i></button>
                                       <form action="{{ route('education-histories.destroy', $edu->id) }}" method="POST" class="inline" onsubmit="return confirm('Xóa hồ sơ học tập này?')">
                                           @csrf @method('DELETE')
                                           <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 transition-colors"><i class="fas fa-trash-alt text-xs"></i></button>
                                       </form>
                                   </div>
                                   @endif
                               </div>
                               <p class="text-xs font-bold text-indigo-500 mb-2 uppercase tracking-wide">{{ $edu->major }}</p>
                               <div class="flex items-center justify-between text-xs text-slate-500 font-bold">
                                   <div class="flex items-center">
                                       <span class="px-2 py-1 bg-slate-100 rounded-md mr-3">{{ $edu->degree }}</span>
                                       <span>Năm: {{ $edu->year }}</span>
                                   </div>
                                   @if($edu->transcript_image)
                                   <a href="{{ asset('storage/' . $edu->transcript_image) }}" target="_blank" class="text-indigo-600 flex items-center hover:underline">
                                       <i class="fas fa-image mr-1"></i> Bảng điểm
                                   </a>
                                   @endif
                               </div>
                           </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-2 py-20 text-center text-slate-400 font-bold italic">Chưa cập nhật thông tin học vấn.</div>
                    @endforelse
                </div>
            </div>

            <!-- Training Tab -->
            <div id="content-training" class="tab-content hidden space-y-6 animate-fade-in">
                <div class="flex justify-between items-center bg-slate-50 p-6 rounded-3xl border border-slate-100">
                    <div>
                        <h4 class="font-black text-slate-900">Quá trình đào tạo</h4>
                        <p class="text-xs text-slate-500 font-medium">Các khóa học nghiệp vụ đã tham gia tại công ty.</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($employee->trainingCourses as $course)
                    <div class="p-6 bg-slate-900 text-white rounded-3xl shadow-xl shadow-slate-900/10">
                        <div class="flex justify-between mb-6">
                            <i class="fas fa-award text-amber-400 text-3xl"></i>
                            <span class="px-2 py-1 bg-white/10 text-[10px] font-black uppercase rounded-lg">Hoàn thành</span>
                        </div>
                        <h5 class="text-lg font-black mb-1">{{ $course->name }}</h5>
                        <p class="text-[10px] text-white/50 font-bold uppercase tracking-wider mb-4">{{ date('d/m/Y', strtotime($course->start_date)) }}</p>
                        <div class="pt-4 border-t border-white/10 flex justify-between items-center">
                            <span class="text-xs font-bold text-white/60">Kết quả:</span>
                            <span class="font-black text-amber-400 uppercase tracking-widest">{{ $course->pivot->result ?? 'N/A' }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-3 py-20 text-center text-slate-400 font-bold italic">Chưa tham gia khóa đào tạo nào.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .tab-content { animation: fadeIn 0.4s ease-out; }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    function switchTab(tabId) {
        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
        // Show target content
        document.getElementById('content-' + tabId).classList.remove('hidden');
        
        // Update tab buttons
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.remove('border-indigo-600', 'text-indigo-600');
            b.classList.add('border-transparent', 'text-slate-400');
        });
        
        const activeTab = document.getElementById('tab-' + tabId);
        activeTab.classList.remove('border-transparent', 'text-slate-400');
        activeTab.classList.add('border-indigo-600', 'text-indigo-600');
    }

    function openEditEduModal(edu) {
        const form = document.getElementById('editEduForm');
        form.action = `/education-histories/${edu.id}`;
        
        document.getElementById('edit_edu_school').value = edu.school;
        document.getElementById('edit_edu_major').value = edu.major;
        document.getElementById('edit_edu_degree').value = edu.degree;
        document.getElementById('edit_edu_year').value = edu.year;
        
        document.getElementById('editEduModal').classList.remove('hidden');
    }
</script>
@endsection
