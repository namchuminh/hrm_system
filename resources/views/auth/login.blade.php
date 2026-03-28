@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="flex items-center justify-center min-h-[80vh] px-4">
    <div class="max-w-md w-full glass border border-white/20 rounded-3xl shadow-2xl p-10 transition-all hover:shadow-indigo-500/20 transform hover:-translate-y-1">
        <div class="text-center mb-10">
            <h2 class="text-4xl font-black text-indigo-900 tracking-tight mb-2">HRM PRO</h2>
            <p class="text-slate-500 font-medium whitespace-nowrap">Đăng nhập vào hệ thống để tiếp tục</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 rounded-xl flex items-start">
                <i class="fas fa-exclamation-circle mt-1 mr-3"></i>
                <ul class="text-sm font-bold">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-sm font-bold text-slate-700 mb-2 ml-1">Địa chỉ Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input id="email" type="email" name="email" required value="{{ old('email') }}" 
                        class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition-all placeholder:text-slate-400" 
                        placeholder="email@company.com">
                </div>
                @error('email') <p class="text-rose-500 text-xs mt-1 font-bold ml-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-slate-700 mb-2 ml-1">Mật khẩu</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input id="password" type="password" name="password" required 
                        class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition-all placeholder:text-slate-400" 
                        placeholder="••••••••">
                </div>
                @error('password') <p class="text-rose-500 text-xs mt-1 font-bold ml-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-between text-sm py-2">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 cursor-pointer">
                    <label for="remember" class="ml-2 text-slate-600 font-medium cursor-pointer">Ghi nhớ đăng nhập</label>
                </div>
                <a href="#" class="font-bold text-indigo-600 hover:text-indigo-500 transition-colors">Quên mật khẩu?</a>
            </div>

            <button type="submit" class="w-full py-4 px-6 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold rounded-2xl shadow-xl shadow-indigo-600/30 transform transition-all hover:-translate-y-1 active:scale-95 focus:ring-4 focus:ring-indigo-200">
                ĐĂNG NHẬP NGAY
            </button>
        </form>

        <div class="mt-10 pt-8 border-t border-slate-100 text-center">
            <p class="text-sm text-slate-500 font-medium">Chưa có tài khoản? <a href="#" class="font-extrabold text-indigo-600 hover:text-indigo-500 transition-colors ml-1">Liên hệ HR</a></p>
        </div>
    </div>
</div>
@endsection
