@extends('layouts.app')

@section('title', 'Tin tuyển dụng')

@section('content')
<div class="max-w-7xl mx-auto pb-12">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight text-indigo-900">Quản lý Tuyển dụng</h1>
            <p class="text-slate-500 font-medium">Công khai vị trí và lộ trình tìm kiếm nhân tài.</p>
        </div>
        <a href="{{ route('job-postings.create') }}" class="px-6 py-3 bg-indigo-600 text-white font-extrabold rounded-2xl shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 transition-all flex items-center group">
            <i class="fas fa-bullhorn mr-2"></i> ĐĂNG TIN MỚI
        </a>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="p-6 bg-slate-50/50 border-b border-slate-100">
            <form action="{{ route('job-postings.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="relative md:col-span-2">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Tìm kiếm vị trí tuyển dụng..." 
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
                <div class="flex gap-2">
                    <button type="submit" class="flex-grow bg-indigo-600 text-white font-extrabold rounded-xl hover:bg-indigo-700 transition-all uppercase text-xs tracking-widest">
                        Lọc tin
                    </button>
                    @if(request()->anyFilled(['search', 'dept_id']))
                        <a href="{{ route('job-postings.index') }}" class="p-3 bg-slate-100 text-slate-500 rounded-xl hover:bg-slate-200 transition-all flex items-center justify-center">
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
                        <th class="px-8 py-5">Vị trí tuyển dụng</th>
                        <th class="px-8 py-5">Phòng ban mục tiêu</th>
                        <th class="px-8 py-5 text-center">Số lượng</th>
                        <th class="px-8 py-5">Hạn nộp hồ sơ</th>
                        <th class="px-8 py-5 text-right font-black uppercase tracking-widest">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($jobPostings as $job)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="font-bold text-slate-900 leading-tight">{{ $job->title }}</div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Yêu cầu: {{ $job->experience_required ?? 'Không yêu cầu' }}</div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-sm font-black text-indigo-600 uppercase">{{ $job->department->name ?? 'N/A' }}</span>
                        </td>
                        <td class="px-8 py-5 text-center font-black text-slate-700">
                            {{ $job->quantity }}
                        </td>
                        <td class="px-8 py-5">
                            <div class="text-xs font-bold text-slate-500 flex items-center">
                                <i class="far fa-calendar-alt mr-1.5 text-indigo-400 text-[10px]"></i>
                                {{ $job->deadline ? date('d/m/Y', strtotime($job->deadline)) : 'Dài hạn' }}
                            </div>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex items-center justify-end space-x-1">
                                <a href="{{ route('job-postings.edit', $job->id) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-white rounded-lg transition-all"><i class="fas fa-edit text-sm"></i></a>
                                <form action="{{ route('job-postings.destroy', $job->id) }}" method="POST" class="inline" onsubmit="return confirm('Xác nhận xóa tin tuyển dụng này?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-white rounded-lg transition-all"><i class="fas fa-trash-alt text-sm"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center text-slate-400 font-bold italic">Chưa có vị trí tuyển dụng nào được đăng.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-6 bg-white border-t border-slate-100">
            {{ $jobPostings->links() }}
        </div>
    </div>
</div>
@endsection
