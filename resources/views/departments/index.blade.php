@extends('layouts.app')

@section('title', 'Phòng ban')

@section('content')
<div class="max-w-7xl mx-auto pb-12">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight text-indigo-900">Cơ cấu tổ chức</h1>
            <p class="text-slate-500 font-medium">Quản lý sơ đồ phòng ban và đơn vị trực thuộc.</p>
        </div>
        <a href="{{ route('departments.create') }}" class="px-6 py-3 bg-indigo-600 text-white font-extrabold rounded-2xl shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 transition-all flex items-center group">
            <i class="fas fa-plus-circle mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
            THÊM PHÒNG BAN
        </a>
    </div>

    <!-- Enhanced Filter Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="p-6 bg-slate-50/50 border-b border-slate-100">
            <form action="{{ route('departments.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="relative md:col-span-2">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Tìm kiếm tên phòng ban hoặc mã bộ phận..." 
                        class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-medium">
                </div>
                <div>
                    <select name="manager_id" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-medium">
                        <option value="">-- Lọc theo Trưởng phòng --</option>
                        @foreach($managers as $m)
                            <option value="{{ $m->id }}" {{ request('manager_id') == $m->id ? 'selected' : '' }}>{{ $m->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-grow bg-indigo-600 text-white font-extrabold rounded-xl hover:bg-indigo-700 transition-all">
                        LỌC
                    </button>
                    @if(request()->anyFilled(['search', 'manager_id']))
                        <a href="{{ route('departments.index') }}" class="p-3 bg-slate-100 text-slate-500 rounded-xl hover:bg-slate-200 transition-all flex items-center justify-center">
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
                        <th class="px-8 py-5">Phòng ban</th>
                        <th class="px-8 py-5">Mã bộ phận</th>
                        <th class="px-8 py-5">Trưởng phòng</th>
                        <th class="px-8 py-5">Nhân sự</th>
                        <th class="px-8 py-5 text-right font-black uppercase tracking-widest">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($departments as $dept)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 mr-4 group-hover:scale-110 transition-transform font-bold">
                                    <i class="fas fa-building text-sm"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 leading-tight">{{ $dept->name }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ Str::limit($dept->description, 35) ?: 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 font-black text-slate-600 text-sm tracking-widest">
                            {{ $dept->code }}
                        </td>
                        <td class="px-8 py-5">
                            @if($dept->manager)
                                <div class="flex items-center">
                                    <div class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-700 text-[10px] font-bold mr-2">
                                        {{ substr($dept->manager->full_name, 0, 1) }}
                                    </div>
                                    <span class="text-xs font-bold text-slate-700 leading-none">{{ $dept->manager->full_name }}</span>
                                </div>
                            @else
                                <span class="text-[10px] text-slate-300 font-black uppercase tracking-tighter">Trống</span>
                            @endif
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-black uppercase">
                                {{ $dept->employees()->count() }} nhân tài
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex items-center justify-end space-x-1">
                                <a href="{{ route('departments.edit', $dept->id) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-white rounded-lg transition-all">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('departments.destroy', $dept->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phòng ban này?')">
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
                        <td colspan="5" class="px-8 py-20 text-center">
                            <p class="text-slate-400 text-sm font-bold italic">Không tìm thấy phòng ban nào phù hợp.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-6 bg-white border-t border-slate-100">
            {{ $departments->links() }}
        </div>
    </div>
</div>
@endsection
