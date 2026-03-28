@extends('layouts.app')

@section('title', 'Danh sách ứng viên')

@section('content')
<div class="max-w-7xl mx-auto pb-12">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight text-indigo-900">Quản lý Ứng viên</h1>
            <p class="text-slate-500 font-medium">Theo dõi hồ sơ và quy trình phỏng vấn nhân tài.</p>
        </div>
        <a href="{{ route('candidates.create') }}" class="px-6 py-3 bg-indigo-600 text-white font-extrabold rounded-2xl shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 transition-all flex items-center group">
            <i class="fas fa-user-plus mr-2"></i> THÊM ỨNG VIÊN
        </a>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="p-6 bg-slate-50/50 border-b border-slate-100">
            <form action="{{ route('candidates.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Tên hoặc email ứng viên..." 
                        class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-medium">
                </div>
                <div>
                    <select name="job_id" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-medium">
                        <option value="">-- Tin tuyển dụng --</option>
                        @foreach(\App\Models\JobPosting::all() as $job)
                            <option value="{{ $job->id }}" {{ request('job_id') == $job->id ? 'selected' : '' }}>{{ $job->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="status" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-medium">
                        <option value="">-- Trạng thái --</option>
                        <option value="Phỏng vấn" {{ request('status') == 'Phỏng vấn' ? 'selected' : '' }}>Phỏng vấn</option>
                        <option value="Đạt" {{ request('status') == 'Đạt' ? 'selected' : '' }}>Đạt (Trúng tuyển)</option>
                        <option value="Loại" {{ request('status') == 'Loại' ? 'selected' : '' }}>Loại (Từ chối)</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-grow bg-indigo-600 text-white font-extrabold rounded-xl hover:bg-indigo-700 transition-all uppercase text-xs tracking-widest">Lọc ứng viên</button>
                    @if(request()->anyFilled(['search', 'job_id', 'status']))
                        <a href="{{ route('candidates.index') }}" class="p-3 bg-slate-100 text-slate-500 rounded-xl hover:bg-slate-200 transition-all flex items-center justify-center">
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
                        <th class="px-8 py-5">Ứng viên</th>
                        <th class="px-8 py-5">Vị trí ứng tuyển</th>
                        <th class="px-8 py-5">Ngày nộp</th>
                        <th class="px-8 py-5 text-center">Trạng thái</th>
                        <th class="px-8 py-5 text-right font-black uppercase tracking-widest">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($candidates as $can)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-xs mr-4 group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-sm">
                                    {{ substr($can->full_name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 leading-none">{{ $can->full_name }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ $can->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-sm font-black text-indigo-500">{{ $can->jobPosting->title ?? 'N/A' }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-xs font-bold text-slate-500">{{ date('d/m/Y', strtotime($can->created_at)) }}</span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            @php
                                $statusBtn = [
                                    'Phỏng vấn' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'Đạt' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'Loại' => 'bg-rose-50 text-rose-600 border-rose-100',
                                ];
                            @endphp
                            <span class="px-3 py-1.5 {{ $statusBtn[$can->status] ?? 'bg-slate-100' }} border rounded-xl text-[9px] font-black uppercase tracking-tight shadow-sm">
                                {{ $can->status }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                             <div class="flex items-center justify-end space-x-1">
                                <button onclick="updateCandidateStatus({{ json_encode($can) }})" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-white rounded-lg transition-all" title="Cập nhật trạng thái"><i class="fas fa-edit text-sm"></i></button>
                                <form action="{{ route('candidates.destroy', $can->id) }}" method="POST" class="inline" onsubmit="return confirm('Xác nhận xóa hồ sơ này?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-white rounded-lg transition-all"><i class="fas fa-trash-alt text-sm"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                         <td colspan="5" class="px-8 py-20 text-center text-slate-400 font-bold italic">Không tìm thấy ứng viên nào phù hợp.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-6 bg-white border-t border-slate-100">
            {{ $candidates->links() }}
        </div>
    </div>
</div>
<!-- Status Update Modal -->
<div id="statusModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden animate-slide-up">
        <form id="statusForm" method="POST">
            @csrf @method('PUT')
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-xl font-black text-slate-900">Trạng thái ứng viên</h3>
                <button type="button" onclick="document.getElementById('statusModal').classList.add('hidden')" class="text-slate-400 hover:text-rose-500 transition-colors"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-8 space-y-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Ứng viên:</label>
                    <input type="text" id="cand_name" readonly class="w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 font-bold outline-none cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Cập nhật trạng thái <span class="text-rose-500">*</span></label>
                    <select name="status" id="cand_status" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-bold">
                        <option value="Phỏng vấn">Phỏng vấn</option>
                        <option value="Đạt">Đạt (Trúng tuyển)</option>
                        <option value="Loại">Loại (Không đạt)</option>
                    </select>
                </div>
            </div>
            <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('statusModal').classList.add('hidden')" class="px-6 py-3 font-bold text-slate-500 hover:text-slate-700 transition-colors uppercase text-xs tracking-wider">Hủy bỏ</button>
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-black rounded-xl shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 active:scale-95 transition-all text-sm uppercase tracking-widest">CẬP NHẬT</button>
            </div>
        </form>
    </div>
</div>

<script>
function updateCandidateStatus(can) {
    document.getElementById('statusForm').action = "/candidates/" + can.id;
    document.getElementById('cand_name').value = can.full_name;
    document.getElementById('cand_status').value = can.status;
    document.getElementById('statusModal').classList.remove('hidden');
}
</script>
@endsection
