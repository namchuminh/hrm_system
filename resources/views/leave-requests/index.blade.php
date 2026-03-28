@extends('layouts.app')

@section('title', 'Đơn nghỉ phép')

@section('content')
@php 
    $user = auth()->user();
    $isManager = $user->hasRole('Admin') || $user->hasRole('HR') || $user->hasRole('Manager');
@endphp
<div class="max-w-7xl mx-auto pb-12">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight text-indigo-900">Quản lý Nghỉ phép</h1>
            <p class="text-slate-500 font-medium">Xét duyệt và theo dõi quỹ thời gian nghỉ của nhân viên.</p>
        </div>
        <a href="{{ route('leave-requests.create') }}" class="px-6 py-3 bg-indigo-600 text-white font-extrabold rounded-2xl shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 transition-all flex items-center group">
            <i class="fas fa-envelope-open-text mr-2"></i> TẠO ĐƠN MỚI
        </a>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="p-6 bg-slate-50/50 border-b border-slate-100">
            <form action="{{ route('leave-requests.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @if($isManager)
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm nhân viên..." class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-medium">
                </div>
                @endif
                <div>
                    <select name="status" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-medium">
                        <option value="">-- Trạng thái --</option>
                        <option value="Chờ duyệt" {{ request('status') == 'Chờ duyệt' ? 'selected' : '' }}>Chờ duyệt</option>
                        <option value="Đồng ý" {{ request('status') == 'Đồng ý' ? 'selected' : '' }}>Đã duyệt</option>
                        <option value="Từ chối" {{ request('status') == 'Từ chối' ? 'selected' : '' }}>Từ chối</option>
                    </select>
                </div>
                <div>
                    <input type="date" name="date" value="{{ request('date') }}" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-medium">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-grow bg-indigo-600 text-white font-extrabold rounded-xl hover:bg-indigo-700 transition-all uppercase text-xs tracking-widest">Lọc kết quả</button>
                    @if(request()->anyFilled(['search', 'status', 'date']))
                        <a href="{{ route('leave-requests.index') }}" class="p-3 bg-slate-100 text-slate-500 rounded-xl hover:bg-slate-200 transition-all"><i class="fas fa-times"></i></a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 text-slate-500 uppercase text-[10px] font-black tracking-widest border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5">Nhân viên</th>
                        <th class="px-8 py-5">Thời gian nghỉ</th>
                        <th class="px-8 py-5">Lý do</th>
                        <th class="px-8 py-5 text-center">Trạng thái</th>
                        <th class="px-8 py-5 text-right font-black uppercase tracking-widest">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($leaveRequests as $lr)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="font-bold text-slate-900 leading-tight">{{ $lr->employee->full_name }}</div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ $lr->employee->department->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="text-sm font-black text-indigo-600 tracking-tight">{{ date('d/m/Y', strtotime($lr->start_date)) }} - {{ date('d/m/Y', strtotime($lr->end_date)) }}</div>
                            <div class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">{{ $lr->leaveType->name ?? 'Nghỉ phép' }}</div>
                        </td>
                        <td class="px-8 py-5">
                            <p class="text-xs text-slate-600 max-w-xs truncate font-medium">{{ $lr->reason }}</p>
                        </td>
                        <td class="px-8 py-5 text-center">
                            @php
                                $statusBtn = [
                                    'Chờ duyệt' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'Đồng ý' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'Từ chối' => 'bg-rose-50 text-rose-600 border-rose-100',
                                ];
                            @endphp
                            <span class="px-3 py-1.5 {{ $statusBtn[$lr->status] ?? 'bg-slate-50 text-slate-600' }} border rounded-xl text-[9px] font-black uppercase tracking-tight">
                                {{ $lr->status }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                             <div class="flex items-center justify-end space-x-1">
                                 @if($isManager && $lr->status == 'Chờ duyệt')
                                    <form action="{{ route('leave-requests.approve', $lr->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all" title="Duyệt đơn">
                                            <i class="fas fa-check text-sm"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('leave-requests.reject', $lr->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Từ chối đơn">
                                            <i class="fas fa-times text-sm"></i>
                                        </button>
                                    </form>
                                 @endif

                                 @if($lr->status == 'Chờ duyệt')
                                 <form action="{{ route('leave-requests.destroy', $lr->id) }}" method="POST" class="inline" onsubmit="return confirm('Xác nhận xóa đơn này?')">
                                     @csrf @method('DELETE')
                                     <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-white rounded-lg transition-all" title="Xóa đơn">
                                         <i class="fas fa-trash-alt text-sm"></i>
                                     </button>
                                 </form>
                                 @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                         <td colspan="5" class="px-8 py-20 text-center text-slate-400 font-bold italic">Không tìm thấy yêu cầu nghỉ phép nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-6 bg-white border-t border-slate-100">
            {{ $leaveRequests->links() }}
        </div>
    </div>
</div>
@endsection
