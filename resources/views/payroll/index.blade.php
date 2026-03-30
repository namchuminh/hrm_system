@extends('layouts.app')

@section('title', 'Bảng lương')

@section('content')
@php $isManager = Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Accountant'); @endphp
<div class="max-w-7xl mx-auto pb-12">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight text-indigo-900">Quản lý Tiền lương</h1>
            <p class="text-slate-500 font-medium">Bảng kê thu nhập và các khoản chi trả nhân sự.</p>
        </div>
        @if($isManager)
        <a href="{{ route('payroll.create') }}" class="px-6 py-3 bg-indigo-600 text-white font-extrabold rounded-2xl shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 transition-all flex items-center group">
            <i class="fas fa-file-invoice-dollar mr-2 group-hover:scale-110 transition-transform duration-300"></i>
            TẠO PHIẾU LƯƠNG
        </a>
        @endif
    </div>

    @if($isManager && $payrolls->isNotEmpty())
    <div class="mb-8 p-8 bg-indigo-900 rounded-3xl text-white shadow-2xl shadow-indigo-900/40 relative overflow-hidden animate-fade-in">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-indigo-200 font-bold uppercase tracking-widest text-xs mb-1">Tổng chi ngân sách lương</h2>
                <p class="text-3xl font-black italic">{{ number_format($totalBudget) }} <span class="text-sm opacity-60">VNĐ</span></p>
                <p class="text-[10px] text-indigo-300 font-medium mt-2 uppercase tracking-widest italic">* Dựa trên kết quả hiển thị hiện tại</p>
            </div>
            <div class="flex gap-4">
                <div class="bg-indigo-800/50 backdrop-blur-xl rounded-2xl p-4 border border-indigo-700/50">
                    <div class="text-[10px] font-black uppercase tracking-widest text-indigo-300 mb-1">Bản ghi kỳ này</div>
                    <div class="text-xl font-black">{{ $payrolls->total() }} phiếu</div>
                </div>
            </div>
        </div>
        <div class="absolute -right-10 -top-10 w-48 h-48 bg-indigo-500/20 rounded-full blur-3xl"></div>
    </div>
    @endif

    <!-- Filter Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="p-6 bg-slate-50/50 border-b border-slate-100">
            <form action="{{ route('payroll.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @if($isManager)
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Tìm nhân viên..." 
                        class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-medium">
                </div>
                @endif
                <div>
                    <select name="month" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-medium">
                        <option value="">-- Chọn Tháng --</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>Tháng {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <select name="year" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-medium">
                        <option value="">-- Chọn Năm --</option>
                        @for($i = date('Y'); $i >= 2020; $i--)
                            <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>Năm {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-grow bg-indigo-600 text-white font-extrabold rounded-xl hover:bg-indigo-700 transition-all">
                        LỌC
                    </button>
                    @if(request()->anyFilled(['search', 'month', 'year']))
                        <a href="{{ route('payroll.index') }}" class="p-3 bg-slate-100 text-slate-500 rounded-xl hover:bg-slate-200 transition-all flex items-center justify-center">
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
                        <th class="px-8 py-5">Kỳ quyết toán</th>
                        <th class="px-8 py-5 text-right">Lương cơ bản</th>
                        <th class="px-8 py-5 text-right">Thưởng/Phụ cấp</th>
                        <th class="px-8 py-5 text-right">Thực nhận</th>
                        <th class="px-8 py-5 text-right font-black uppercase tracking-widest">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($payrolls as $pay)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="font-bold text-slate-900 leading-tight">{{ $pay->employee->full_name }}</div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ $pay->employee->employee_code }}</div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-xs font-black text-slate-600 uppercase">THÁNG {{ $pay->month }}/{{ $pay->year }}</span>
                        </td>
                        <td class="px-8 py-5 text-right font-black text-slate-700">
                            {{ number_format($pay->basic_salary) }}
                        </td>
                        <td class="px-8 py-5 text-right text-emerald-600 font-black">
                            +{{ number_format($pay->allowance + $pay->bonus) }}
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="text-sm font-black text-indigo-600">{{ number_format($pay->net_salary) }} <span class="text-[8px] opacity-60">VNĐ</span></div>
                            <div class="text-[10px] text-emerald-500 font-bold uppercase tracking-tight mt-0.5">Đã quyết toán <i class="fas fa-check-circle ml-1"></i></div>
                        </td>
                        <td class="px-8 py-5 text-right flex justify-end space-x-2">
                            @if($isManager)
                            <a href="{{ route('payroll.edit', $pay->id) }}" class="p-2 text-slate-400 hover:text-amber-600 hover:bg-white rounded-lg transition-all" title="Sửa phiếu lương">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endif
                            <a href="{{ route('payroll.show', $pay->employee_id) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-white rounded-lg transition-all" title="Xem chi tiết & In phiếu lương">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center">
                            <p class="text-slate-400 text-sm font-bold italic">Chưa có dữ liệu lương trong kỳ này.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-6 bg-white border-t border-slate-100">
            {{ $payrolls->links() }}
        </div>
    </div>
</div>
@endsection
