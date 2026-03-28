<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRM PRO - Hệ thống Quản trị Nhân sự</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Inter', sans-serif; }
            .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
        </style>
    </head>
    <body class="bg-slate-50 text-slate-900 antialiased overflow-x-hidden">
        <!-- Hero Section -->
        <div class="relative min-h-screen flex items-center justify-center p-6">
            <div class="absolute inset-0 z-0">
                <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-200/30 rounded-full blur-3xl"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-emerald-200/30 rounded-full blur-3xl"></div>
            </div>

            <div class="relative z-10 max-w-4xl w-full">
                <div class="text-center space-y-8">
                    <div class="inline-flex items-center px-4 py-2 bg-white rounded-full shadow-sm border border-slate-100 text-slate-500 font-bold text-xs uppercase tracking-widest mb-4">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                        Hệ thống sẵn sàng
                    </div>
                    
                    <h1 class="text-6xl md:text-8xl font-black text-slate-900 tracking-tighter leading-none">
                        HRM <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-indigo-400">PRO</span>
                    </h1>
                    
                    <p class="text-xl text-slate-600 max-w-2xl mx-auto font-medium">
                        Giải pháp quản trị nhân sự toàn diện, tinh gọn và hiện đại cho doanh nghiệp của bạn.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center pt-8">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-600/30 hover:bg-indigo-700 hover:-translate-y-1 transition-all">
                                Truy cập Bảng điều khiển
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-600/30 hover:bg-indigo-700 hover:-translate-y-1 transition-all flex items-center justify-center">
                                <i class="fas fa-sign-in-alt mr-2"></i> Đăng nhập hệ thống
                            </a>
                        @endauth
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-20">
                        <div class="bg-white/50 p-6 rounded-3xl border border-slate-100 backdrop-blur-sm text-left">
                            <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-4">
                                <i class="fas fa-users-cog"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 mb-2">Quản lý Nhân sự</h3>
                            <p class="text-slate-500 text-sm">Quản lý hồ sơ, phòng ban và chức vụ một cách khoa học.</p>
                        </div>
                        <div class="bg-white/50 p-6 rounded-3xl border border-slate-100 backdrop-blur-sm text-left">
                            <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mb-4">
                                <i class="fas fa-money-check-alt"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 mb-2">Tiền lương & Chế độ</h3>
                            <p class="text-slate-500 text-sm">Tính lương tự động dựa trên chấm công và trợ cấp.</p>
                        </div>
                        <div class="bg-white/50 p-6 rounded-3xl border border-slate-100 backdrop-blur-sm text-left">
                            <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center mb-4">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 mb-2">Tuyển dụng</h3>
                            <p class="text-slate-500 text-sm">Tìm kiếm và thu hút tài năng cho sự phát triển của công ty.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="py-12 text-center text-slate-400 text-sm font-medium border-t border-slate-100 bg-white">
            &copy; {{ date('Y') }} HRM PRO. Tất cả quyền được bảo lưu.
        </footer>
    </body>
</html>
