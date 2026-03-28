@extends('layouts.app')

@section('title', 'Lịch sử Điểm danh')

@section('content')
<div class="max-w-7xl mx-auto pb-12">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight text-indigo-900">Lịch sử Điểm danh</h1>
            <p class="text-slate-500 font-medium">Theo dõi hoạt động ra vào và kỷ luật nhân sự.</p>
        </div>
        <div class="flex space-x-3">
             @if(Auth::user()->employee)
                 <form action="{{ route('attendance.checkin') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-3 bg-emerald-600 text-white font-extrabold rounded-2xl shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 transition-all flex items-center">
                        <i class="fas fa-sign-in-alt mr-2"></i> CHECK-IN
                    </button>
                </form>
                <form action="{{ route('attendance.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-3 bg-rose-600 text-white font-extrabold rounded-2xl shadow-lg shadow-rose-600/20 hover:bg-rose-700 transition-all flex items-center">
                        <i class="fas fa-sign-out-alt mr-2"></i> CHECK-OUT
                    </button>
                </form>
             @endif
        </div>
    </div>

    <!-- Summary Section -->
    <div class="grid grid-cols-1 md:grid-cols-{{ $isManager ? '1' : '1' }} gap-6 mb-8">
        <div class="bg-indigo-900 rounded-3xl p-8 text-white relative overflow-hidden shadow-2xl shadow-indigo-900/40">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h2 class="text-indigo-200 font-bold uppercase tracking-widest text-xs mb-1">
                        Thống kê chuyên cần tháng {{ $targetDate->format('m/Y') }}
                    </h2>
                    <p class="text-3xl font-black italic">
                        @if($isManager)
                            TỔNG HỢP CÔNG NHÂN VIÊN
                        @else
                            TỔNG SỐ NGÀY CÔNG: {{ $summary->first()->total_days ?? 0 }} NGÀY
                        @endif
                    </p>
                </div>
                @if($isManager)
                <div class="bg-indigo-800/50 backdrop-blur-xl rounded-2xl p-4 border border-indigo-700/50">
                    <div class="text-[10px] font-black uppercase tracking-widest text-indigo-300 mb-1">Dữ liệu hiện tại</div>
                    <div class="text-xl font-black">{{ $summary->count() }} Nhân viên đã điểm danh</div>
                </div>
                @endif
            </div>
            <!-- Decorative circle -->
            <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl"></div>
        </div>
    </div>

    @if($isManager)
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8 animate-slide-up">
        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-tight">Bảng tổng kết công nhân sự</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Lọc theo giai đoạn & Phòng ban</p>
            </div>
            
            <form action="{{ route('attendance.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <select name="month" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold focus:ring-2 focus:ring-indigo-500 outline-none">
                    @for($m=1; $m<=12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>Tháng {{ $m }}</option>
                    @endfor
                </select>
                <select name="year" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold focus:ring-2 focus:ring-indigo-500 outline-none">
                    @for($y=date('Y'); $y>=date('Y')-5; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>Năm {{ $y }}</option>
                    @endfor
                </select>
                <select name="department_id" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold focus:ring-2 focus:ring-indigo-500 outline-none">
                    <option value="">Tất cả phòng ban</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ $departmentId == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="p-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-600/20">
                    <i class="fas fa-filter"></i>
                </button>
            </form>
        </div>
        <div class="max-h-64 overflow-y-auto overflow-x-auto sidebar-scroll">
             <table class="w-full text-left border-collapse min-w-[600px]">
                <thead class="sticky top-0 bg-white shadow-sm text-slate-400 uppercase text-[9px] font-black tracking-widest">
                    <tr class="border-b border-slate-100">
                        <th class="px-8 py-4">Nhân viên</th>
                        <th class="px-8 py-4 text-center">Số công (P/M)</th>
                        <th class="px-8 py-4 text-right">Tỷ lệ công chuẩn (26 ngày)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($summary as $row)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-4">
                            <div class="font-bold text-slate-700 text-xs">{{ $row->employee->full_name }}</div>
                            <div class="text-[8px] text-slate-400 font-bold">{{ $row->employee->employee_code }}</div>
                        </td>
                        <td class="px-8 py-4 text-center text-sm font-black text-indigo-600">{{ $row->total_days }}</td>
                        <td class="px-8 py-4 text-right">
                             @php $percent = min(($row->total_days / 26) * 100, 100); @endphp
                             <div class="flex items-center justify-end">
                                 <span class="text-[10px] font-black mr-2 text-slate-400">{{ round($percent) }}%</span>
                                 <div class="bg-slate-100 rounded-full h-1.5 w-24">
                                    <div class="bg-indigo-500 h-1.5 rounded-full" style="width: {{ $percent }}%"></div>
                                 </div>
                             </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
             </table>
        </div>
    </div>
    @endif

    <!-- Filter Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="p-6 bg-slate-50/50 border-b border-slate-100">
            <form action="{{ route('attendance.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @if($isManager)
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Tìm kiếm nhân viên..." 
                        class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-medium">
                </div>
                @endif
                <div>
                     <input type="date" name="date" value="{{ request('date') ?? $targetDate->toDateString() }}" 
                        class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-medium">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-grow bg-indigo-600 text-white font-extrabold rounded-xl hover:bg-indigo-700 transition-all uppercase text-sm">
                        LỌC DỮ LIỆU
                    </button>
                    @if(request()->anyFilled(['search', 'date']))
                        <a href="{{ route('attendance.index') }}" class="p-3 bg-slate-100 text-slate-500 rounded-xl hover:bg-slate-200 transition-all flex items-center justify-center">
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
                        <th class="px-8 py-5">Ngày công</th>
                        <th class="px-8 py-5 text-center">Giờ vào</th>
                        <th class="px-8 py-5 text-center">Giờ ra</th>
                        <th class="px-8 py-5 text-right font-black uppercase tracking-widest">Trạng thái</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($attendances as $att)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="font-bold text-slate-900 leading-tight">{{ $att->employee->full_name }}</div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ $att->employee->employee_code }}</div>
                        </td>
                        <td class="px-8 py-5 font-black text-slate-700 text-sm">
                            {{ \Carbon\Carbon::parse($att->date)->format('d/m/Y') }}
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">
                                <i class="far fa-clock mr-1"></i> {{ $att->check_in ? $att->check_in->format('H:i:s') : '--:--:--' }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            @if($att->check_out)
                                <span class="px-3 py-1 bg-rose-50 text-rose-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">
                                    <i class="far fa-clock mr-1"></i> {{ $att->check_out->format('H:i:s') }}
                                </span>
                            @else
                                <span class="text-[8px] text-slate-300 font-black uppercase tracking-widest italic">Chưa check-out</span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-right">
                             @if($att->status == 'P')
                                <span class="px-3 py-1.5 bg-emerald-100 text-emerald-700 rounded-xl text-[10px] font-black uppercase tracking-tight">Có mặt</span>
                             @elseif($att->status == 'M')
                                <span class="px-3 py-1.5 bg-amber-100 text-amber-700 rounded-xl text-[10px] font-black uppercase tracking-tight">Đi muộn</span>
                             @elseif($att->status == 'V')
                                <span class="px-3 py-1.5 bg-rose-100 text-rose-700 rounded-xl text-[10px] font-black uppercase tracking-tight">Vắng mặt</span>
                             @else
                                <span class="px-3 py-1.5 bg-slate-100 text-slate-500 rounded-xl text-[10px] font-black uppercase tracking-tight">{{ $att->status }}</span>
                             @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <p class="text-slate-400 text-sm font-bold italic">Không có dữ liệu điểm danh nào được tìm thấy.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-6 bg-white border-t border-slate-100">
            {{ $attendances->links() }}
        </div>
    </div>
</div>
@endsection
