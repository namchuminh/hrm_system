@extends('layouts.app')

@section('title', 'Bảng điều khiển')

@section('content')
@php
    $user = auth()->user();
    $employee = $user->employee;
    $roles = $user->roles->pluck('name')->toArray();
    $isAdmin = in_array('Admin', $roles);
    $isHR = in_array('HR', $roles);
    $isAccountant = in_array('Accountant', $roles);
    $isManager = in_array('Manager', $roles);
    $isRegularEmployee = count($roles) === 0 || in_array('Employee', $roles);

    // Common Data
    $now = \Carbon\Carbon::now();
    $month = $now->month;
    $year = $now->year;
@endphp

<div class="space-y-10 pb-12">
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight">
                Chào {{ $isAdmin || $isHR || $isManager ? 'Sếp' : '' }} <span class="text-indigo-600">{{ $user->name }}</span>!
            </h1>
            <p class="text-slate-500 font-medium mt-1">
                @if($isAdmin || $isHR)
                    Hệ thống HRM đang vận hành ổn định với {{ \App\Models\Employee::count() }} nhân sự.
                @elseif($isAccountant)
                    Theo dõi ngân sách và quyết toán lương tháng {{ $month }}.
                @else
                    Bạn đã có một khởi đầu tuyệt vời hôm nay.
                @endif
            </p>
        </div>
        <div class="flex space-x-3">
            <div class="px-4 py-2 bg-white border border-slate-200 rounded-2xl shadow-sm text-sm font-bold text-slate-600 flex items-center">
                <i class="far fa-calendar-alt mr-2 text-indigo-500"></i> {{ date('d/m/Y') }}
            </div>
            <div class="px-4 py-2 bg-indigo-600 text-white rounded-2xl shadow-lg shadow-indigo-600/20 text-sm font-black flex items-center">
                {{ date('H:i') }}
            </div>
        </div>
    </div>

    @if($isRegularEmployee && !$isAdmin && !$isHR && !$isAccountant && !$isManager)
        <!-- Employee Dashboard: Personal Performance & Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-200 relative overflow-hidden group">
                    <div class="relative z-10">
                        <h3 class="text-slate-400 font-black text-xs uppercase tracking-widest mb-6">Hiệu suất chuyên cần</h3>
                        @php
                            $attendanceCount = \App\Models\Attendance::where('employee_id', $employee->id)
                                ->whereMonth('date', $month)->whereYear('date', $year)
                                ->whereIn('status', ['P', 'M'])->count();
                            $targetDays = 26;
                            $percent = min(($attendanceCount / $targetDays) * 100, 100);
                        @endphp
                        <div class="flex items-end justify-between mb-4">
                            <span class="text-6xl font-black text-slate-900">{{ $attendanceCount }}<span class="text-xl text-slate-300 ml-2">/ {{ $targetDays }} ngày</span></span>
                            <span class="text-indigo-600 font-black text-xl italic">{{ round($percent) }}% Hoàn thành</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-4 overflow-hidden">
                            <div class="bg-indigo-600 h-4 rounded-full transition-all duration-1000" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                    <div class="absolute -right-10 -top-10 text-slate-50 opacity-10 text-[12rem] group-hover:rotate-12 transition-transform duration-700">
                        <i class="fas fa-check-double"></i>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @php
                        $usedLeave = \App\Models\LeaveRequest::where('employee_id', $employee->id)->where('status', 'Đồng ý')->whereYear('start_date', $year)->count();
                        $remainingLeave = max(12 - $usedLeave, 0);
                    @endphp
                    <div class="bg-emerald-600 p-8 rounded-3xl text-white shadow-xl shadow-emerald-600/20 relative overflow-hidden group">
                        <h3 class="text-emerald-200 font-black text-[10px] uppercase tracking-widest mb-2">Quỹ phép năm</h3>
                        <p class="text-4xl font-black">{{ $remainingLeave }} <span class="text-xs opacity-60">Ngày còn lại</span></p>
                        <i class="fas fa-umbrella-beach absolute -right-4 -bottom-4 text-white/10 text-7xl group-hover:scale-110 transition-transform"></i>
                    </div>

                    @php $latestPayroll = \App\Models\Payroll::where('employee_id', $employee->id)->latest()->first(); @endphp
                    <div class="bg-indigo-900 p-8 rounded-3xl text-white shadow-xl shadow-indigo-900/20 relative overflow-hidden group">
                        <h3 class="text-indigo-300 font-black text-[10px] uppercase tracking-widest mb-2">Thanh toán lương</h3>
                        <p class="text-2xl font-black">{{ $latestPayroll ? number_format($latestPayroll->net_salary) : '---' }} <span class="text-[10px] opacity-60 uppercase">VNĐ</span></p>
                        <p class="text-[10px] text-indigo-400 font-bold mt-2 italic">{{ $latestPayroll ? 'Tháng ' . $latestPayroll->month . '/' . $latestPayroll->year : 'Chưa có phiếu lương' }}</p>
                        <i class="fas fa-wallet absolute -right-4 -bottom-4 text-white/10 text-7xl group-hover:scale-110 transition-transform"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-slate-200">
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-8 border-b border-slate-100 pb-4">Thông tin công ty</h3>
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mr-4 flex-shrink-0"><i class="fas fa-building text-sm"></i></div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase">Phòng ban</p>
                            <p class="text-sm font-extrabold text-slate-700">{{ $employee->department->name ?? 'Chưa cập nhật' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mr-4 flex-shrink-0"><i class="fas fa-user-tag text-sm"></i></div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase">Chức vụ</p>
                            <p class="text-sm font-extrabold text-slate-700">{{ $employee->position->name ?? 'Nhân sự' }}</p>
                        </div>
                    </div>
                    <div class="pt-6 border-t border-slate-50">
                        <a href="{{ route('profile.index') }}" class="w-full py-4 bg-slate-50 text-slate-600 rounded-2xl text-[10px] font-black uppercase tracking-widest flex items-center justify-center hover:bg-slate-100 transition-all">
                            Xem hồ sơ cá nhân <i class="fas fa-id-card ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @elseif($isAccountant && !$isAdmin)
        <!-- Accountant Dashboard: Financial Metrics & Budgeting -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="space-y-8">
                @php
                    $totalBudget = \App\Models\Payroll::where('month', $month)->where('year', $year)->sum('net_salary');
                    $payrollCount = \App\Models\Payroll::where('month', $month)->where('year', $year)->count();
                    $totalEmployees = \App\Models\Employee::count();
                @endphp
                <div class="bg-indigo-900 p-10 rounded-[3rem] text-white shadow-2xl shadow-indigo-900/40 relative overflow-hidden group">
                    <div class="relative z-10">
                        <h3 class="text-indigo-300 font-black text-xs uppercase tracking-widest mb-3">Tổng chi lương tháng {{ $month }}/{{ $year }}</h3>
                        <p class="text-5xl font-black italic">{{ number_format($totalBudget) }} <span class="text-sm opacity-60">VNĐ</span></p>
                        <div class="mt-8 flex items-center gap-4">
                            <div class="px-5 py-2.5 bg-indigo-800/50 rounded-2xl border border-indigo-700 text-xs font-black uppercase tracking-widest">
                                 {{ $payrollCount }} / {{ $totalEmployees }} Phiếu lương
                            </div>
                        </div>
                    </div>
                    <i class="fas fa-file-invoice-dollar absolute -right-10 -bottom-10 text-white/5 text-[15rem] group-hover:scale-105 transition-transform duration-1000"></i>
                </div>

                <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-slate-200">
                    <h3 class="text-lg font-black text-slate-900 mb-8 flex items-center">
                        <span class="w-2 h-6 bg-indigo-600 rounded-full mr-3"></span> Cơ cấu lương theo phòng ban
                    </h3>
                    <div class="relative h-64">
                        <canvas id="salaryDeptChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-200 h-full flex flex-col items-center justify-center text-center">
                 <div class="w-24 h-24 bg-rose-50 text-rose-600 rounded-full flex items-center justify-center text-4xl mb-8 animate-bounce">
                    <i class="fas fa-hand-holding-usd"></i>
                 </div>
                 <h3 class="text-2xl font-black text-slate-800 mb-2">Tiến độ chi tiền lương</h3>
                 <p class="text-slate-500 font-medium mb-8 max-w-sm">Vui lòng kiểm tra và phê duyệt các phiếu lương còn thiếu cho {{ $totalEmployees - $payrollCount }} nhân viên.</p>
                 
                 <div class="w-full max-w-md bg-slate-100 rounded-full h-4 mb-4 overflow-hidden">
                    @php $percent = $totalEmployees > 0 ? ($payrollCount / $totalEmployees) * 100 : 0; @endphp
                    <div class="bg-emerald-500 h-4 rounded-full transition-all duration-1000" style="width: {{ $percent }}%"></div>
                 </div>
                 <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">{{ round($percent) }}% Đã hoàn thành</p>
                 
                 <a href="{{ route('payroll.index') }}" class="mt-10 px-10 py-4 bg-indigo-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 transition-all flex items-center">
                    Xem bảng lương tổng quát <i class="fas fa-external-link-alt ml-2"></i>
                 </a>
            </div>
        </div>

        @php
            $salaryStats = \App\Models\Department::with(['employees.payrolls' => function($q) use ($month, $year) {
                $q->where('month', $month)->where('year', $year);
            }])->get()->map(function($dept) {
                return [
                    'name' => $dept->name,
                    'total' => $dept->employees->sum(function($emp) {
                        return $emp->payrolls->sum('net_salary');
                    })
                ];
            });
            $salaryLabels = $salaryStats->pluck('name')->toArray();
            $salaryData = $salaryStats->pluck('total')->toArray();
        @endphp
    @else
        <!-- Admin / HR / Manager Dashboard Content -->
        @php
            $totalEmployees = \App\Models\Employee::count();
            $totalDepts = \App\Models\Department::count();
            $pendingLeaves = \App\Models\LeaveRequest::where('status', 'Chờ duyệt')->count();
            $activePostings = \App\Models\JobPosting::count();
            
            $deptStats = \App\Models\Department::withCount('employees')->get();
            $labels = $deptStats->pluck('name')->toArray();
            $data = $deptStats->pluck('employees_count')->toArray();
        @endphp

        <!-- Key Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 hover:shadow-xl hover:shadow-indigo-500/5 transition-all group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-xl group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <h3 class="text-slate-500 font-bold text-xs uppercase tracking-widest">Tổng nhân sự</h3>
                <p class="text-3xl font-black text-slate-900 mt-1">{{ $totalEmployees }}</p>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 hover:shadow-xl hover:shadow-indigo-500/5 transition-all group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center text-xl group-hover:bg-rose-600 group-hover:text-white transition-colors">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest bg-rose-50 px-2 py-1 rounded-lg">{{ $pendingLeaves }} Mới</span>
                </div>
                <h3 class="text-slate-500 font-bold text-xs uppercase tracking-widest">Đơn nghỉ phép</h3>
                <p class="text-3xl font-black text-slate-900 mt-1">{{ $pendingLeaves }}</p>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 hover:shadow-xl hover:shadow-indigo-500/5 transition-all group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-xl group-hover:bg-amber-600 group-hover:text-white transition-colors">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                </div>
                <h3 class="text-slate-500 font-bold text-xs uppercase tracking-widest">Đang tuyển dụng</h3>
                <p class="text-3xl font-black text-slate-900 mt-1">{{ $activePostings }}</p>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 hover:shadow-xl hover:shadow-indigo-500/5 transition-all group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <i class="fas fa-building"></i>
                    </div>
                </div>
                <h3 class="text-slate-500 font-bold text-xs uppercase tracking-widest">Phòng ban</h3>
                <p class="text-3xl font-black text-slate-900 mt-1">{{ $totalDepts }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200">
                <h3 class="text-lg font-black text-slate-900 mb-6 flex items-center">
                    <span class="w-2 h-6 bg-indigo-600 rounded-full mr-3"></span> Phân bổ Nhân sự
                </h3>
                <div class="relative h-64">
                    <canvas id="deptChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200">
                <h3 class="text-lg font-black text-slate-900 mb-6 flex items-center">
                    <span class="w-2 h-6 bg-rose-500 rounded-full mr-3"></span> Hoạt động nhân sự mới
                </h3>
                <div class="space-y-6">
                    @php $recentEmployees = \App\Models\Employee::latest()->take(4)->get(); @endphp
                    @foreach($recentEmployees as $emp)
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 border border-slate-100 flex items-center justify-center font-black text-slate-400 mr-4 group-hover:bg-indigo-600 group-hover:text-white transition-all overflow-hidden shrink-0">
                                @if($emp->avatar)
                                    <img src="{{ asset('storage/' . $emp->avatar) }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($emp->full_name, 0, 1) }}
                                @endif
                            </div>
                            <div>
                                <p class="font-bold text-slate-900 text-sm">{{ $emp->full_name }}</p>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">{{ $emp->department->name ?? 'HR' }}</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">{{ date('d M, Y', strtotime($emp->join_date)) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if($isAccountant && !$isAdmin)
        const sctx = document.getElementById('salaryDeptChart').getContext('2d');
        new Chart(sctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($salaryLabels ?? []) !!},
                datasets: [{
                    label: 'Thanh toán lương (VNĐ)',
                    data: {!! json_encode($salaryData ?? []) !!},
                    backgroundColor: '#4f46e5',
                    borderRadius: 12,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { 
                    y: { beginAtZero: true, grid: { display: false }, border: { display: false } },
                    x: { grid: { display: false }, border: { display: false } }
                }
            }
        });
    @elseif(!$isRegularEmployee || $isAdmin || $isHR || $isManager)
        const ctx = document.getElementById('deptChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($labels ?? []) !!},
                datasets: [{
                    data: {!! json_encode($data ?? []) !!},
                    backgroundColor: ['#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#6366f1'],
                    borderWidth: 0,
                    hoverOffset: 20
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { usePointStyle: true, padding: 20, font: { weight: 'bold', family: "'Inter', sans-serif" } }
                    }
                },
                cutout: '70%'
            }
        });
    @endif
</script>
@endsection
