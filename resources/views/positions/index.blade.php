@extends('layouts.app')

@section('title', 'Chức vụ')

@section('content')
<div class="max-w-7xl mx-auto pb-12">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight text-indigo-900">Danh mục Chức vụ</h1>
            <p class="text-slate-500 font-medium">Quản lý các cấp bậc và định mức lương định kỳ.</p>
        </div>
        <a href="{{ route('positions.create') }}" class="px-6 py-3 bg-indigo-600 text-white font-extrabold rounded-2xl shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 transition-all flex items-center group">
            <i class="fas fa-plus-circle mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
            THÊM CHỨC VỤ
        </a>
    </div>

    <!-- Search Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="p-6 bg-slate-50/50 border-b border-slate-100">
            <form action="{{ route('positions.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-grow">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Tìm kiếm tên chức vụ chính xác..." 
                        class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-medium">
                </div>
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-extrabold rounded-xl hover:bg-indigo-700 transition-all">
                    TÌM KIẾM
                </button>
                @if(request('search'))
                    <a href="{{ route('positions.index') }}" class="p-3 bg-slate-100 text-slate-500 rounded-xl hover:bg-slate-200 transition-all flex items-center justify-center">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 text-slate-500 uppercase text-[10px] font-black tracking-widest border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5">Tên chức vụ</th>
                        <th class="px-8 py-5">Lương cơ bản</th>
                        <th class="px-8 py-5">Phụ cấp định kỳ</th>
                        <th class="px-8 py-5 text-right font-black uppercase tracking-widest">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($positions as $pos)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 mr-4 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                    <i class="fas fa-user-tag text-sm"></i>
                                </div>
                                <div class="font-bold text-slate-900 leading-tight">{{ $pos->name }}</div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="font-black text-slate-700 text-sm tracking-tight">{{ number_format($pos->basic_salary) }} <span class="text-[10px] text-slate-400 ml-0.5">VNĐ</span></div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="font-black text-emerald-600 text-sm tracking-tight flex items-center">
                                <i class="fas fa-plus mr-1 text-[8px]"></i> {{ number_format($pos->allowance) }} <span class="text-[10px] text-emerald-400 ml-0.5 opacity-60">VNĐ</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex items-center justify-end space-x-1">
                                <a href="{{ route('positions.edit', $pos->id) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-white rounded-lg transition-all" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('positions.destroy', $pos->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa chức vụ này?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-white rounded-lg transition-all" title="Xóa">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center">
                            <p class="text-slate-400 text-sm font-bold italic">Không tìm thấy chức vụ thích hợp.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-6 bg-white border-t border-slate-100">
            {{ $positions->links() }}
        </div>
    </div>
</div>
@endsection
