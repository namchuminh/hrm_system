@extends('layouts.app')

@section('title', 'Quản lý hợp đồng')

@section('content')
<div class="max-w-7xl mx-auto pb-12">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight text-indigo-900">Quản lý Hợp đồng</h1>
            @if($isManager && (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('HR')))
                <p class="text-slate-500 font-medium">Lưu trữ và theo dõi các giao kèo pháp lý nhân sự.</p>
            @else
                <p class="text-slate-500 font-medium">Xem và tải xuống hợp đồng lao động của bạn.</p>
            @endif
        </div>
        @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('HR'))
        <button onclick="document.getElementById('addContractModal').classList.remove('hidden')" 
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-extrabold shadow-lg shadow-indigo-600/20 transition-all hover:-translate-y-1 active:scale-95 flex items-center justify-center">
            <i class="fas fa-file-contract mr-2"></i> THÊM HỢP ĐỒNG MỚI
        </button>
        @endif
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="p-6 bg-slate-50/50 border-b border-slate-100">
            <form action="{{ route('contracts.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="relative md:col-span-2">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-medium" 
                        placeholder="Tìm nhân viên, mã nhân viên hoặc số hợp đồng...">
                </div>
                <div>
                    <select name="type" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-medium">
                        <option value="">-- Tất cả loại HĐ --</option>
                        <option value="Thời hạn" {{ request('type') == 'Thời hạn' ? 'selected' : '' }}>HĐ Có thời hạn</option>
                        <option value="Vô thời hạn" {{ request('type') == 'Vô thời hạn' ? 'selected' : '' }}>HĐ Vô thời hạn</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-grow bg-indigo-600 text-white font-extrabold rounded-xl hover:bg-indigo-700 transition-all uppercase text-xs tracking-widest">
                        Lọc kết quả
                    </button>
                    @if(request()->anyFilled(['search', 'type']))
                        <a href="{{ route('contracts.index') }}" class="p-3 bg-slate-100 text-slate-500 rounded-xl hover:bg-slate-200 transition-all flex items-center justify-center">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 text-slate-500 uppercase text-[10px] font-black tracking-widest border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5">Số Hợp đồng</th>
                        <th class="px-8 py-5">Nhân sự</th>
                        <th class="px-8 py-5">Loại hình</th>
                        <th class="px-8 py-5">Thời gian thực hiện</th>
                        <th class="px-8 py-5 text-right font-black uppercase tracking-widest">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($contracts as $contract)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-5">
                             <span class="font-black text-indigo-600 text-sm tracking-widest uppercase">{{ $contract->contract_number }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-xs mr-3 group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-sm">
                                    {{ substr($contract->employee->full_name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 leading-none">{{ $contract->employee->full_name }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ $contract->employee->employee_code }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-sm font-black text-slate-600 uppercase tracking-tight">{{ $contract->type }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="text-[11px] font-black text-slate-700 tracking-tight">
                                {{ date('d/m/Y', strtotime($contract->start_date)) }} - {{ $contract->end_date ? date('d/m/Y', strtotime($contract->end_date)) : 'Hợp đồng dài hạn' }}
                            </div>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex items-center justify-end space-x-1">
                                <a href="{{ route('contracts.show', $contract->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Xem hợp đồng">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('HR'))
                                <button onclick="editContract({{ json_encode($contract) }})" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-white rounded-lg transition-all" title="Sửa hợp đồng">
                                    <i class="fas fa-edit text-sm"></i>
                                </button>
                                <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST" class="inline" onsubmit="return confirm('Xác nhận xóa hợp đồng này?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-white rounded-lg transition-all">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                         <td colspan="5" class="px-8 py-20 text-center text-slate-400 font-bold italic">Chưa đăng ký hợp đồng nào trong hệ thống.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-6 bg-white border-t border-slate-100">
            {{ $contracts->links() }}
        </div>
    </div>
</div>

<!-- Add Modal -->
<div id="addContractModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden animate-slide-up max-h-[90vh] overflow-y-auto">
        <form action="{{ route('contracts.store') }}" method="POST">
            @csrf
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 sticky top-0 bg-white z-10">
                <h3 class="text-xl font-black text-slate-900">Thêm Hợp đồng mới</h3>
                <button type="button" onclick="document.getElementById('addContractModal').classList.add('hidden')" class="text-slate-400 hover:text-rose-500 transition-colors"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nhân viên <span class="text-rose-500">*</span></label>
                        <select name="employee_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-bold">
                            <option value="">-- Chọn nhân viên --</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->full_name }} ({{ $emp->employee_code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Số hợp đồng <span class="text-rose-500">*</span></label>
                        <input type="text" name="contract_number" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-bold uppercase tracking-widest" placeholder="HĐ-2024-001">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Loại hợp đồng <span class="text-rose-500">*</span></label>
                        <select name="type" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-bold">
                            <option value="Thời hạn">Có thời hạn</option>
                            <option value="Vô thời hạn">Vô thời hạn</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Thời gian làm việc</label>
                        <input type="text" name="working_time" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="Ví dụ: 08 giờ/ngày (48 giờ/tuần)">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Lương chính thức (VNĐ)</label>
                        <input type="number" name="salary_amount" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-bold" placeholder="15000000">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Lương thử việc (VNĐ)</label>
                        <input type="number" name="probation_salary" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-bold" placeholder="12000000">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Ngày bắt đầu</label>
                        <input type="date" name="start_date" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-bold">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Ngày kết thúc</label>
                        <input type="date" name="end_date" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-bold">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Phụ cấp & Thỏa thuận khác</label>
                    <textarea name="allowances_text" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-medium" placeholder="Nhập các khoản phụ cấp hoặc ghi chú khác..."></textarea>
                </div>
            </div>
            <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex justify-end space-x-3 sticky bottom-0 bg-white">
                <button type="button" onclick="document.getElementById('addContractModal').classList.add('hidden')" class="px-6 py-3 font-bold text-slate-500 hover:text-slate-700 transition-colors uppercase text-xs tracking-wider">Hủy bỏ</button>
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-black rounded-xl shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 active:scale-95 transition-all text-sm uppercase tracking-widest">Tạo HĐ mới</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editContractModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden animate-slide-up max-h-[90vh] overflow-y-auto">
        <form id="editContractForm" method="POST">
            @csrf @method('PUT')
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 sticky top-0 bg-white z-10">
                <h3 class="text-xl font-black text-slate-900">Cập nhật Hợp đồng</h3>
                <button type="button" onclick="document.getElementById('editContractModal').classList.add('hidden')" class="text-slate-400 hover:text-rose-500 transition-colors"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Nhân viên (Không được đổi)</label>
                        <input type="text" id="edit_employee_name" readonly class="w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 font-bold outline-none cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Số hợp đồng <span class="text-rose-500">*</span></label>
                        <input type="text" name="contract_number" id="edit_contract_number" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-bold uppercase tracking-widest">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Loại hợp đồng <span class="text-rose-500">*</span></label>
                        <select name="type" id="edit_type" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-bold">
                            <option value="Thời hạn">Có thời hạn</option>
                            <option value="Vô thời hạn">Vô thời hạn</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Thời gian làm việc</label>
                        <input type="text" name="working_time" id="edit_working_time" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="Ví dụ: 08 giờ/ngày (48 giờ/tuần)">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Lương chính thức (VNĐ)</label>
                        <input type="number" name="salary_amount" id="edit_salary_amount" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-bold">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Lương thử việc (VNĐ)</label>
                        <input type="number" name="probation_salary" id="edit_probation_salary" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-bold">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Ngày bắt đầu</label>
                        <input type="date" name="start_date" id="edit_start_date" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-bold">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Ngày kết thúc</label>
                        <input type="date" name="end_date" id="edit_end_date" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-bold">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Phụ cấp & Thỏa thuận khác</label>
                    <textarea name="allowances_text" id="edit_allowances_text" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-medium"></textarea>
                </div>
            </div>
            <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex justify-end space-x-3 sticky bottom-0 bg-white">
                <button type="button" onclick="document.getElementById('editContractModal').classList.add('hidden')" class="px-6 py-3 font-bold text-slate-500 hover:text-slate-700 transition-colors uppercase text-xs tracking-wider">Hủy bỏ</button>
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-black rounded-xl shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 active:scale-95 transition-all text-sm uppercase tracking-widest">Cập nhật HĐ</button>
            </div>
        </form>
    </div>
</div>

<script>
function editContract(contract) {
    document.getElementById('editContractForm').action = "/contracts/" + contract.id;
    document.getElementById('edit_employee_name').value = contract.employee.full_name;
    document.getElementById('edit_contract_number').value = contract.contract_number;
    document.getElementById('edit_type').value = contract.type;
    document.getElementById('edit_start_date').value = contract.start_date;
    document.getElementById('edit_end_date').value = contract.end_date || '';
    document.getElementById('edit_working_time').value = contract.working_time || '';
    document.getElementById('edit_salary_amount').value = contract.salary_amount || '';
    document.getElementById('edit_probation_salary').value = contract.probation_salary || '';
    document.getElementById('edit_allowances_text').value = contract.allowances_text || '';
    
    document.getElementById('editContractModal').classList.remove('hidden');
}
</script>
@endsection
