@extends('layouts.app')

@section('title', 'Danh sách nhân viên')

@section('content')
<div class="max-w-7xl mx-auto pb-12">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight text-indigo-900">Nhân sự Hệ thống</h1>
            <p class="text-slate-500 font-medium">Quản lý định danh và hồ sơ nghề nghiệp của đội ngũ.</p>
        </div>
        <a href="{{ route('employees.create') }}" class="px-6 py-3 bg-indigo-600 text-white font-extrabold rounded-2xl shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 transition-all flex items-center group">
            <i class="fas fa-plus-circle mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
            TIẾP NHẬN NHÂN VIÊN
        </a>
    </div>

    <!-- Advanced Search & Filter Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="p-6 bg-slate-50/50 border-b border-slate-100">
            <form action="{{ route('employees.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Tên, mã NV..." 
                        class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-medium">
                </div>
                <div>
                    <select name="dept_id" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-medium">
                        <option value="">-- Tất cả phòng ban --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ request('dept_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="status" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-medium">
                        <option value="">-- Trạng thái --</option>
                        <option value="Đang làm" {{ request('status') == 'Đang làm' ? 'selected' : '' }}>Đang làm việc</option>
                        <option value="Thử việc" {{ request('status') == 'Thử việc' ? 'selected' : '' }}>Thử việc</option>
                        <option value="Nghỉ việc" {{ request('status') == 'Nghỉ việc' ? 'selected' : '' }}>Nghỉ việc</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-grow bg-indigo-600 text-white font-extrabold rounded-xl hover:bg-indigo-700 transition-all uppercase text-xs tracking-widest">
                        Lọc kết quả
                    </button>
                    @if(request()->anyFilled(['search', 'dept_id', 'status']))
                        <a href="{{ route('employees.index') }}" class="p-3 bg-slate-100 text-slate-500 rounded-xl hover:bg-slate-200 transition-all">
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
                        <th class="px-8 py-5">Nhân viên</th>
                        <th class="px-8 py-5">Vai trò & Đơn vị</th>
                        <th class="px-8 py-5">Ngày gia nhập</th>
                        <th class="px-8 py-5">Trạng thái</th>
                        <th class="px-8 py-5 text-right font-black uppercase tracking-widest">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($employees as $emp)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center">
                                <div class="w-11 h-11 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-black text-sm mr-4 group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-sm overflow-hidden">
                                    @if($emp->avatar)
                                        <img src="{{ asset('storage/' . $emp->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                        {{ substr($emp->full_name, 0, 1) }}
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 leading-tight">{{ $emp->full_name }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ $emp->employee_code }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="text-sm text-slate-700 font-bold mb-0.5 leading-none">{{ $emp->department->name ?? 'N/A' }}</div>
                            <div class="text-[10px] text-indigo-500 font-black uppercase tracking-widest">{{ $emp->position->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="text-sm font-black text-slate-700">{{ $emp->join_date ? date('d/m/Y', strtotime($emp->join_date)) : 'N/A' }}</div>
                        </td>
                        <td class="px-8 py-5">
                             @php
                                $statusColors = [
                                    'Đang làm' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'Thử việc' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'Nghỉ việc' => 'bg-rose-50 text-rose-600 border-rose-100',
                                ];
                            @endphp
                            <span class="px-2.5 py-1 {{ $statusColors[$emp->status] ?? 'bg-slate-100 text-slate-600' }} rounded-lg text-[9px] font-black uppercase border tracking-tighter">
                                {{ $emp->status }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex items-center justify-end space-x-1">
                                <a href="{{ route('employees.show', $emp->id) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-white rounded-lg transition-all">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('employees.edit', $emp->id) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-white rounded-lg transition-all">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('employees.destroy', $emp->id) }}" method="POST" class="inline" onsubmit="return confirm('Xác nhận xóa nhân viên này?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-white rounded-lg transition-all">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center text-slate-400 font-bold italic">Không có nhân sự nào khớp với tìm kiếm.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-6 bg-white border-t border-slate-100">
            {{ $employees->links() }}
        </div>
    </div>
</div>
@endsection
