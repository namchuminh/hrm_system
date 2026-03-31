<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRM System - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
        @media (max-width: 1023px) {
            .mobile-sidebar { 
                position: fixed; 
                top: 0; 
                left: 0; 
                height: 100vh; 
                z-index: 50; 
                transform: translateX(-100%); 
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .sidebar-active { transform: translateX(0) !important; }
        }
        
        @media (min-width: 1024px) {
            .main-content { min-width: 0; }
        }
        
        /* Custom Scrollbar */
        .overflow-x-auto, .sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: rgba(99, 102, 241, 0.2) transparent;
        }
        .overflow-x-auto::-webkit-scrollbar, .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb, .sidebar-scroll::-webkit-scrollbar-thumb {
            background-color: rgba(99, 102, 241, 0.2);
            border-radius: 20px;
        }
        .overflow-x-auto::-webkit-scrollbar-track, .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        
        /* Fancy Transitions */
        .animate-fade-in { animation: fadeIn 0.3s ease-out; }
        .animate-slide-up { animation: slideUp 0.3s ease-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="min-h-screen flex">
        @auth
        <!-- Mobile Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 z-40 hidden transition-opacity opacity-0"></div>

        <!-- Sidebar -->
        <aside id="main-sidebar" class="w-64 bg-indigo-900 text-white flex-shrink-0 hidden lg:flex flex-col mobile-sidebar lg:sticky lg:top-0 h-screen overflow-y-auto sidebar-scroll z-50 shadow-2xl lg:shadow-none min-h-screen">
            <div class="p-6">
                <h1 class="text-2xl font-bold tracking-tight">HRM <span class="text-indigo-400">Pro</span></h1>
            </div>
            <nav class="mt-8">
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('dashboard') ? 'bg-indigo-800 text-white' : 'text-indigo-300' }} hover:bg-indigo-800 transition-colors">
                    <i class="fas fa-chart-line mr-3"></i> Bảng điều khiển
                </a>
                <a href="{{ route('profile.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('profile.*') ? 'bg-indigo-800 text-white' : 'text-indigo-300' }} hover:bg-indigo-800 transition-colors">
                    <i class="fas fa-user-circle mr-3"></i> Hồ sơ của tôi
                </a>

                @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('HR') || Auth::user()->hasRole('Manager'))
                <div class="px-6 py-4 text-xs font-bold text-indigo-100 uppercase tracking-widest bg-indigo-900/50">Quản lý nhân sự</div>
                <a href="{{ route('employees.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('employees.*') ? 'bg-indigo-800 text-white' : 'text-indigo-300' }} hover:bg-indigo-800 transition-colors">
                    <i class="fas fa-users mr-3"></i> Danh sách nhân viên
                </a>
                @endif

                @if(Auth::user()->hasRole('Admin'))
                <a href="{{ route('departments.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('departments.*') ? 'bg-indigo-800 text-white' : 'text-indigo-300' }} hover:bg-indigo-800 transition-colors">
                    <i class="fas fa-building mr-3"></i> Phòng ban
                </a>
                <a href="{{ route('positions.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('positions.*') ? 'bg-indigo-800 text-white' : 'text-indigo-300' }} hover:bg-indigo-800 transition-colors">
                    <i class="fas fa-briefcase mr-3"></i> Chức vụ
                </a>
                @endif
                
                <div class="px-6 py-4 text-xs font-bold text-indigo-100 uppercase tracking-widest bg-indigo-900/50">Hồ sơ công việc</div>
                <a href="{{ route('contracts.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('contracts.*') ? 'bg-indigo-800 text-white' : 'text-indigo-300' }} hover:bg-indigo-800 transition-colors">
                    <i class="fas fa-file-signature mr-3"></i> 
                    {{ Auth::user()->hasRole('Admin') || Auth::user()->hasRole('HR') ? 'Quản lý hợp đồng' : 'Hợp đồng của tôi' }}
                </a>
                <a href="{{ route('training-courses.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('training-courses.*') ? 'bg-indigo-800 text-white' : 'text-indigo-300' }} hover:bg-indigo-800 transition-colors">
                    <i class="fas fa-graduation-cap mr-3"></i> 
                    {{ Auth::user()->hasRole('Admin') || Auth::user()->hasRole('HR') ? 'Quản lý đào tạo' : 'Khóa đào tạo của tôi' }}
                </a>

                <div class="px-6 py-4 text-xs font-bold text-indigo-100 uppercase tracking-widest bg-indigo-900/50">Công việc</div>
                @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('HR') || Auth::user()->hasRole('Accountant') || Auth::user()->hasRole('Manager') || Auth::user()->hasRole('Employee'))
                <a href="{{ route('attendance.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('attendance.*') ? 'bg-indigo-800 text-white' : 'text-indigo-300' }} hover:bg-indigo-800 transition-colors">
                    <i class="fas fa-clock mr-3"></i> Điểm danh
                </a>
                @endif
                <a href="{{ route('leave-requests.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('leave-requests.*') ? 'bg-indigo-800 text-white' : 'text-indigo-300' }} hover:bg-indigo-800 transition-colors">
                    <i class="fas fa-envelope-open-text mr-3"></i> Nghỉ phép
                </a>

                @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('HR'))
                <div class="px-6 py-4 text-xs font-bold text-indigo-100 uppercase tracking-widest bg-indigo-900/50">Tuyển dụng</div>
                <a href="{{ route('job-postings.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('job-postings.*') ? 'bg-indigo-800 text-white' : 'text-indigo-300' }} hover:bg-indigo-800 transition-colors">
                    <i class="fas fa-bullhorn mr-3"></i> Tin tuyển dụng
                </a>
                <a href="{{ route('candidates.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('candidates.*') ? 'bg-indigo-800 text-white' : 'text-indigo-300' }} hover:bg-indigo-800 transition-colors">
                    <i class="fas fa-user-tie mr-3"></i> Ứng viên
                </a>
                @endif

                <div class="px-6 py-4 text-xs font-bold text-indigo-100 uppercase tracking-widest bg-indigo-900/50">Tài chính</div>
                <a href="{{ route('payroll.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('payroll.*') ? 'bg-indigo-800 text-white' : 'text-indigo-300' }} hover:bg-indigo-800 transition-colors">
                    <i class="fas fa-money-check-alt mr-3"></i> 
                    @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Accountant'))
                        Quản lý bảng lương
                    @else
                        Lương của tôi
                    @endif
                </a>

                @if(Auth::user()->hasRole('Admin'))
                <div class="px-6 py-4 text-xs font-bold text-indigo-100 uppercase tracking-widest bg-indigo-900/50">Cấu hình</div>
                <a href="{{ route('settings.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('settings.*') ? 'bg-indigo-800 text-white' : 'text-indigo-300' }} hover:bg-indigo-800 transition-colors">
                    <i class="fas fa-cogs mr-3"></i> Cài đặt hệ thống
                </a>
                @endif
            </nav>
        </aside>
        @endauth

        <div class="flex-1 flex flex-col min-w-0 bg-slate-50/50">
            @auth
            <!-- Header -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 md:px-8">
                <div class="flex items-center text-slate-500 overflow-hidden">
                    <button id="sidebar-toggle" class="lg:hidden mr-4 text-indigo-600 focus:outline-none p-2 rounded-xl hover:bg-slate-50 transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <a href="{{ route('profile.index') }}" class="group flex items-center truncate">
                        @php $employee = Auth::user()->employee; @endphp
                        @if($employee && $employee->avatar)
                            <div class="mr-3 w-8 h-8 rounded-full border border-indigo-100 overflow-hidden shadow-sm flex-shrink-0">
                                <img src="{{ asset('storage/' . $employee->avatar) }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="mr-3 w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-xs flex-shrink-0">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                        <span class="font-medium tracking-tight truncate max-w-[120px] md:max-w-none">
                            <span class="hidden sm:inline">Chào mừng quay lại, </span>
                            <span class="text-indigo-600 font-bold group-hover:underline">{{ Auth::user()->name }}</span>
                        </span>
                        @if(Auth::user()->roles->count() > 0)
                            <span class="ml-2 px-2 py-0.5 bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase rounded-lg border border-indigo-100 whitespace-nowrap">
                                {{ Auth::user()->roles->first()->name }}
                            </span>
                        @endif
                    </a>
                </div>
                <div class="flex items-center space-x-3 md:space-x-6">
                    <div class="relative">
                        <button id="notification-toggle" class="text-slate-400 hover:text-indigo-600 transition-colors relative focus:outline-none p-2 rounded-xl hover:bg-slate-50">
                            <i class="fas fa-bell text-lg md:text-xl"></i>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="absolute -top-1 -right-1 block h-4 w-4 rounded-full bg-rose-500 ring-2 ring-white text-[8px] flex items-center justify-center text-white font-black animate-pulse">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </button>

                        <!-- Notification Dropdown -->
                        <div id="notification-dropdown" class="absolute right-0 mt-4 w-80 bg-white rounded-2xl shadow-2xl border border-slate-100 hidden z-50 overflow-hidden animate-slide-up">
                            <div class="p-4 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                                <h4 class="text-xs font-black uppercase tracking-widest text-slate-400">Thông báo mới</h4>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 text-[9px] font-black rounded-full">{{ auth()->user()->unreadNotifications->count() }} mới</span>
                                @endif
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                                    <div class="p-4 hover:bg-slate-50 transition-colors border-b border-slate-50 last:border-0 cursor-pointer">
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0 text-xs shadow-sm">
                                                <i class="fas fa-bell"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800 leading-tight">{{ $notification->data['title'] ?? 'Thông báo hệ thống' }}</p>
                                                <p class="text-[10px] text-slate-500 mt-1 line-clamp-2">{{ $notification->data['message'] ?? 'Bạn có thông báo mới.' }}</p>
                                                <p class="text-[9px] text-slate-400 font-medium mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-8 text-center">
                                        <div class="w-10 h-10 bg-slate-50 text-slate-200 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <i class="fas fa-bell-slash"></i>
                                        </div>
                                        <p class="text-xs text-slate-400 font-bold italic">Không có thông báo mới</p>
                                    </div>
                                @endforelse
                            </div>
                            <a href="{{ route('notifications.index') }}" class="block p-4 text-center text-xs font-black text-indigo-600 hover:bg-slate-50 transition-colors border-t border-slate-50 uppercase tracking-widest">
                                Xem tất cả thông báo
                            </a>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center text-sm font-extrabold text-slate-700 hover:text-rose-600 transition-all group p-2 rounded-xl hover:bg-slate-50">
                            <span class="hidden sm:inline mr-2">Đăng xuất</span>
                            <i class="fas fa-sign-out-alt transform group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </form>
                </div>
            </header>
            @endauth

            <!-- Content -->
            <main class="flex-1 p-4 md:p-8 main-content">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl flex items-center font-bold text-sm shadow-sm animate-fade-in">
                        <i class="fas fa-check-circle mr-3"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-rose-50 border border-rose-100 text-rose-600 rounded-2xl flex items-center font-bold text-sm shadow-sm">
                        <i class="fas fa-exclamation-circle mr-3"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('notification-toggle');
            const dropdown = document.getElementById('notification-dropdown');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('main-sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            // Notification Dropdown
            if (toggle && dropdown) {
                toggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!dropdown.contains(e.target) && !toggle.contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            }

            // Mobile Sidebar Toggle
            if (sidebarToggle && sidebar && overlay) {
                const openSidebar = () => {
                    sidebar.classList.remove('hidden');
                    sidebar.classList.add('flex', 'sidebar-active');
                    overlay.classList.remove('hidden');
                    setTimeout(() => overlay.classList.add('opacity-100'), 10);
                };

                const closeSidebar = () => {
                    sidebar.classList.remove('sidebar-active', 'flex');
                    sidebar.classList.add('hidden');
                    overlay.classList.remove('opacity-100');
                    setTimeout(() => overlay.classList.add('hidden'), 300);
                };

                sidebarToggle.addEventListener('click', openSidebar);
                overlay.addEventListener('click', closeSidebar);
            }
        });
    </script>
</body>
</html>
