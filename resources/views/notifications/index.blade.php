@extends('layouts.app')

@section('title', 'Thông báo')

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight text-indigo-900">Trung tâm Thông báo</h1>
            <p class="text-slate-500 font-medium">Cập nhật những diễn biến mới nhất từ hệ thống.</p>
        </div>
        @if(auth()->user()->unreadNotifications->count() > 0)
        <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
            @csrf
            <button type="submit" class="text-sm font-black text-indigo-600 hover:text-indigo-800 transition-colors uppercase tracking-widest">
                Đánh dấu tất cả là đã đọc
            </button>
        </form>
        @endif
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <ul class="divide-y divide-slate-100">
            @forelse($notifications as $notification)
                <li class="p-6 hover:bg-slate-50 transition-colors {{ $notification->unread() ? 'bg-indigo-50/30' : '' }}">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 {{ $notification->unread() ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'bg-slate-100 text-slate-400' }}">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="flex-grow">
                            <div class="flex items-center justify-between gap-4">
                                <h4 class="font-bold text-slate-900 {{ $notification->unread() ? '' : 'text-slate-500' }}">
                                    {{ $notification->data['title'] ?? 'Thông báo hệ thống' }}
                                </h4>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-sm text-slate-600 mt-1 {{ $notification->unread() ? 'font-medium' : '' }}">
                                {{ $notification->data['message'] ?? 'Bạn có một thông báo mới.' }}
                            </p>
                            @if($notification->unread())
                            <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="mt-3">
                                @csrf
                                <button type="submit" class="text-[10px] font-black text-indigo-600 hover:text-indigo-800 uppercase tracking-widest flex items-center">
                                    Đánh dấu đã đọc <i class="fas fa-check ml-1"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </li>
            @empty
                <li class="p-20 text-center">
                    <div class="w-16 h-16 bg-slate-50 text-slate-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bell-slash text-2xl"></i>
                    </div>
                    <p class="text-slate-400 font-bold italic">Không có thông báo nào.</p>
                </li>
            @endforelse
        </ul>
        @if($notifications->hasPages())
        <div class="p-6 border-t border-slate-100">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
