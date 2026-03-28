@extends('layouts.app')

@section('title', 'Đào tạo nhân sự')

@section('content')
<div class="max-w-7xl mx-auto pb-12">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight text-indigo-900">Danh mục Đào tạo</h1>
            <p class="text-slate-500 font-medium">Nâng cao năng lực chuyên môn và kỹ năng thực hành.</p>
        </div>
        <button onclick="document.getElementById('addCourseModal').classList.remove('hidden')" 
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-extrabold shadow-lg shadow-indigo-600/20 transition-all hover:-translate-y-1 active:scale-95 flex items-center justify-center">
            <i class="fas fa-plus-circle mr-2"></i> THÊM KHÓA ĐÀO TẠO
        </button>
    </div>

    <!-- Search Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="p-6 bg-slate-50/50 border-b border-slate-100">
            <form action="{{ route('training-courses.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-grow">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Tìm kiếm tên khóa đào tạo nghiệp vụ..." 
                        class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm font-medium">
                </div>
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-extrabold rounded-xl hover:bg-indigo-700 transition-all uppercase text-sm">
                    TÌM KIẾM
                </button>
                 @if(request('search'))
                    <a href="{{ route('training-courses.index') }}" class="p-3 bg-white border border-slate-100 text-slate-500 rounded-xl hover:bg-slate-200 transition-all flex items-center justify-center">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 p-8">
            @forelse($courses as $course)
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl hover:shadow-indigo-500/5 transition-all group flex flex-col h-full border-b-4 border-b-indigo-500">
                <div class="p-6 flex-grow space-y-4">
                    <div class="flex justify-between items-start">
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-sm">
                            <i class="fas fa-graduation-cap text-xl"></i>
                        </div>
                        <div class="flex space-x-1 opacity-100 transition-opacity">
                            <button onclick="editCourse({{ json_encode($course) }})" class="p-2 text-slate-400 hover:text-indigo-600 transition-all"><i class="fas fa-edit"></i></button>
                            <form action="{{ route('training-courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Xác nhận xóa khóa học này?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition-all"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-2 leading-tight">{{ $course->name }}</h3>
                        <p class="text-slate-500 text-xs mt-3 line-clamp-3 font-medium leading-relaxed">{{ $course->description ?? 'Nội dung đào tạo chưa được cập nhật chi tiết.' }}</p>
                    </div>
                </div>
                <div class="p-6 pt-0 border-t border-slate-50 mt-auto bg-slate-50/50">
                    <div class="flex items-center justify-between text-[10px] font-black text-slate-400 uppercase tracking-widest pt-4">
                        <div class="flex items-center">
                            <i class="far fa-calendar-alt mr-2"></i>
                            {{ $course->start_date ? date('d/m/Y', strtotime($course->start_date)) : 'N/A' }}
                        </div>
                        <div class="px-2 py-1 bg-indigo-50 text-indigo-600 rounded-lg">
                            Hoạt động
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-32 flex flex-col items-center justify-center">
                <div class="w-24 h-24 bg-slate-50 rounded-3xl flex items-center justify-center mb-6 border border-slate-100">
                     <i class="fas fa-book-open text-slate-200 text-5xl"></i>
                </div>
                <p class="text-slate-400 font-black italic tracking-tight">Hệ thống chưa ghi nhận chương trình đào tạo nào.</p>
            </div>
            @endforelse
        </div>
        
        <div class="p-6 bg-white border-t border-slate-100">
            {{ $courses->links() }}
        </div>
    </div>
</div>

<!-- Add Modal -->
<div id="addCourseModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden animate-slide-up">
        <form action="{{ route('training-courses.store') }}" method="POST">
            @csrf
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-xl font-black text-slate-900">Thêm Khóa Đào tạo</h3>
                <button type="button" onclick="document.getElementById('addCourseModal').classList.add('hidden')" class="text-slate-400 hover:text-rose-500"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-8 space-y-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tên chương trình đào tạo <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-slate-900" placeholder="VD: Kỹ năng giao tiếp chuyên nghiệp">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Mô tả nội dung</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all text-sm" placeholder="Mục tiêu và nội dung chính của khóa học..."></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 font-mono uppercase tracking-tighter text-[10px]">Ngày bắt đầu</label>
                        <input type="date" name="start_date" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 font-mono uppercase tracking-tighter text-[10px]">Ngày kết thúc dự kiến</label>
                        <input type="date" name="end_date" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                </div>
            </div>
            <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('addCourseModal').classList.add('hidden')" class="px-6 py-3 font-bold text-slate-500 hover:text-slate-700 transition-colors uppercase text-xs tracking-wider">Hủy bỏ</button>
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-black rounded-xl shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 active:scale-95 transition-all text-sm uppercase tracking-widest">Tạo khóa học</button>
            </div>
        </form>
    </div>
</div>
<!-- Edit Modal -->
<div id="editCourseModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden animate-slide-up">
        <form id="editCourseForm" method="POST">
            @csrf @method('PUT')
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-xl font-black text-slate-900">Cập nhật Khóa Đào tạo</h3>
                <button type="button" onclick="document.getElementById('editCourseModal').classList.add('hidden')" class="text-slate-400 hover:text-rose-500"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-8 space-y-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tên chương trình đào tạo <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="edit_name" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-slate-900">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Mô tả nội dung</label>
                    <textarea name="description" id="edit_description" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all text-sm"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 font-mono uppercase tracking-tighter text-[10px]">Ngày bắt đầu</label>
                        <input type="date" name="start_date" id="edit_start_date" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 font-mono uppercase tracking-tighter text-[10px]">Ngày kết thúc dự kiến</label>
                        <input type="date" name="end_date" id="edit_end_date" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                </div>
            </div>
            <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('editCourseModal').classList.add('hidden')" class="px-6 py-3 font-bold text-slate-500 hover:text-slate-700 transition-colors uppercase text-xs tracking-wider">Hủy bỏ</button>
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-black rounded-xl shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 active:scale-95 transition-all text-sm uppercase tracking-widest">Cập nhật khóa học</button>
            </div>
        </form>
    </div>
</div>

<script>
function editCourse(course) {
    document.getElementById('editCourseForm').action = "/training-courses/" + course.id;
    document.getElementById('edit_name').value = course.name;
    document.getElementById('edit_description').value = course.description || '';
    document.getElementById('edit_start_date').value = course.start_date || '';
    document.getElementById('edit_end_date').value = course.end_date || '';
    
    document.getElementById('editCourseModal').classList.remove('hidden');
}
</script>
@endsection
