@extends('layouts.app')

@section('title', 'Hợp đồng lao động chính thức')

@section('content')
<style>
    @media print {
        header, aside, .nav-breadcrumb, .print-btn-container, .sidebar-toggle, #sidebar-toggle {
            display: none !important;
        }
        .main-content, .flex-1, body {
            padding: 0 !important;
            margin: 0 !important;
            background: white !important;
        }
        .contract-document {
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            width: 100% !important;
            max-width: none !important;
        }
    }
    .contract-document {
        font-family: 'Times New Roman', Times, serif;
        background: white;
        line-height: 1.6;
        color: #1a1a1a;
    }
    .line-spacer { border-bottom: 2px solid #333; width: 150px; margin: 10px auto; }
</style>

<div class="max-w-4xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-8 print-btn-container">
        <div>
            <h1 class="text-3xl font-black text-indigo-900 tracking-tight">Hợp đồng lao động</h1>
            <p class="text-slate-500 font-medium italic">Bản điện tử chính thức được trích xuất từ Hệ thống Quản trị Nhân sự.</p>
        </div>
        @if($contract)
        <button onclick="window.print()" class="px-8 py-4 bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-600/30 hover:bg-indigo-700 hover:-translate-y-1 active:scale-95 transition-all flex items-center uppercase tracking-widest text-xs">
            <i class="fas fa-print mr-2 text-lg"></i> IN HỢP ĐỒNG NGAY
        </button>
        @endif
    </div>

    @if(!$contract)
        <div class="bg-amber-50 border-l-4 border-amber-400 p-8 rounded-2xl shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-amber-400 text-2xl mr-4"></i>
                <div>
                    <h3 class="font-black text-amber-800 tracking-tight">Dữ liệu chưa sẵn sàng</h3>
                    <p class="text-amber-700 font-medium">Bạn chưa có dữ liệu hợp đồng lao động điện tử. Vui lòng liên hệ bộ phận HCNS để được cập nhật thông tin.</p>
                </div>
            </div>
        </div>
    @else
        <div class="contract-document bg-white rounded-3xl p-12 md:p-16 shadow-2xl shadow-slate-200/50 border border-slate-100">
            <!-- Header -->
            <div class="text-center mb-10">
                <h2 class="text-lg font-bold uppercase m-0 leading-tight">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h2>
                <h3 class="text-base font-bold uppercase mt-1 mb-0 italic">Độc lập - Tự do - Hạnh phúc</h3>
                <div class="line-spacer"></div>
                <p class="text-sm font-medium mt-4">Số hiệu: <span class="font-bold underline">{{ $contract->contract_number }}</span> / HĐLĐ-VNR</p>
            </div>

            <!-- Title -->
            <div class="text-center mb-10">
                <h1 class="text-2xl font-bold uppercase m-0">HỢP ĐỒNG LAO ĐỘNG</h1>
                <p class="text-base italic font-bold mt-2">(Mẫu số 01/LĐ - Ban hành kèm theo Quyết định số 123/QĐ-HRM)</p>
            </div>

            <div class="space-y-6 text-sm">
                <div class="clause">
                    <p><b>CHÚNG TÔI, MỘT BÊN LÀ (NGƯỜI SỬ DỤNG LAO ĐỘNG):</b></p>
                    <p>Đại diện cho: <b>CÔNG TY TNHH GIẢI PHÁP QUẢN TRỊ HRM PRO</b></p>
                    <p>Ông/Bà: <b>VŨ ĐỨC LONG</b> &nbsp;&nbsp;&nbsp;&nbsp; Chức vụ: <b>GIÁM ĐỐC</b></p>
                    <p>Địa chỉ trụ sở: Khu đô thị mới Cầu Giấy, Quận Cầu Giấy, TP. Hà Nội</p>
                    <p>Mã số thuế: 0109876543 &nbsp;&nbsp;&nbsp;&nbsp; Điện thoại: (024) 3795 1234</p>
                </div>
                
                <div class="py-2 border-b border-dashed border-slate-200"></div>

                <div class="clause">
                    <p><b>VÀ MỘT BÊN LÀ (NGƯỜI LAO ĐỘNG):</b></p>
                    <p>Ông/Bà: <b class="text-lg">{{ $employee->full_name }}</b></p>
                    <div class="grid grid-cols-2 gap-4 mt-1">
                        <p>Ngày sinh: <b>{{ $employee->dob ? date('d/m/Y', strtotime($employee->dob)) : '........' }}</b></p>
                        <p>Giới tính: <b>{{ $employee->gender ?? '..........' }}</b></p>
                    </div>
                    <p>Quê quán / Nơi sinh: <b>{{ $employee->pob ?? '................................' }}</b></p>
                    <p>Quốc tịch: <b>{{ $employee->nationality ?? 'Việt Nam' }}</b></p>
                    <p>Địa chỉ thường trú: <b>{{ $employee->address ?? '................................................................' }}</b></p>
                    <div class="grid grid-cols-3 gap-2 mt-1">
                        <p class="col-span-1">Số CCCD/CMND: <b>{{ $employee->identity_number ?? '....................' }}</b></p>
                        <p class="col-span-1">Cấp ngày: <b>{{ $employee->identity_date ? date('d/m/Y', strtotime($employee->identity_date)) : '........' }}</b></p>
                        <p class="col-span-1">Tại: <b>{{ $employee->identity_place ?? '........' }}</b></p>
                    </div>
                    <p>Trình độ đào tạo chuyên môn: <b>{{ $employee->education ?? '................................' }}</b></p>
                    <div class="grid grid-cols-2 gap-4 mt-1">
                        <p>Mã số thuế cá nhân: <b>{{ $employee->tax_code ?? '....................' }}</b></p>
                        <p>Số sổ BHXH: <b>{{ $employee->social_insurance_number ?? '....................' }}</b></p>
                    </div>
                    <p>Tài khoản ngân hàng: <b>{{ $employee->bank_account ?? '................' }}</b> tại <b>{{ $employee->bank_name ?? '................' }}</b></p>
                </div>

                <div class="py-2 border-b border-dashed border-slate-200"></div>

                <div class="clause">
                    <p class="font-bold underline uppercase">Điều 1: Thời hạn và công việc hợp đồng</p>
                    <p>- Loại hợp đồng lao động: <b>{{ $contract->type }}</b></p>
                    <p>- Thời hạn hợp đồng: Từ ngày <b>{{ date('d/m/Y', strtotime($contract->start_date)) }}</b> đến ngày <b>{{ $contract->end_date ? date('d/m/Y', strtotime($contract->end_date)) : 'Vô thời hạn' }}</b></p>
                    <p>- Chức danh chuyên môn: <b>{{ $employee->position->name ?? 'Nhân viên' }}</b> thuộc bộ phận <b>{{ $employee->department->name ?? '........' }}</b></p>
                </div>

                <div class="clause">
                    <p class="font-bold underline uppercase">Điều 2: Chế độ làm việc</p>
                    <p>- Thời gian làm việc: <b>{{ $contract->working_time ?? '08 giờ/ngày (48 giờ/tuần)' }}</b></p>
                    <p>- Địa điểm làm việc: Trụ sở chính và các địa điểm theo yêu cầu công tác của Công ty.</p>
                </div>

                <div class="clause">
                    <p class="font-bold underline uppercase">Điều 3: Nghĩa vụ và quyền lợi của người lao động</p>
                    <p>1. Quyền lợi:</p>
                    <p>- Mức lương chính thức: <b class="text-indigo-600">{{ $contract->salary_amount ? number_format($contract->salary_amount) . ' VNĐ/tháng' : 'Theo thỏa thuận' }}</b></p>
                    <p>- Lương trong thời kỳ thử việc: <b>{{ $contract->probation_salary ? number_format($contract->probation_salary) . ' VNĐ/tháng' : '........' }}</b></p>
                    <p>- Phụ cấp: <b>{{ $contract->allowances_text ?? 'Theo quy định chung của Công ty' }}</b></p>
                    <p>- Hình thức trả lương: Chuyển khoản qua ngân hàng vào ngày 10 hàng tháng.</p>
                    <p>2. Nghĩa vụ: Chấp hành nghiêm chỉnh nội quy lao động và quy trình nghiệp vụ của Công ty.</p>
                </div>

                <div class="clause">
                    <p class="font-bold underline uppercase">Điều 4: Nghĩa vụ và quyền hạn của người sử dụng lao động</p>
                    <p>- Bảo đảm việc làm và thực hiện đầy đủ các chế độ thù lao cho người lao động.</p>
                </div>

                <div class="pt-6 italic text-right">
                    Hà Nội, ngày {{ date('d') }} tháng {{ date('m') }} năm {{ date('Y') }}
                </div>

                <div class="flex justify-between text-center pt-6 pb-20">
                    <div class="w-1/2">
                        <h4 class="font-bold uppercase mb-1">NGƯỜI LAO ĐỘNG</h4>
                        <p class="text-xs italic">(Ký, ghi rõ họ tên)</p>
                        <div class="h-24"></div>
                        <p class="font-bold text-lg underline">{{ $employee->full_name }}</p>
                    </div>
                    <div class="w-1/2">
                        <h4 class="font-bold uppercase mb-1">NGƯỜI SỬ DỤNG LAO ĐỘNG</h4>
                        <p class="text-xs italic">(Ký, đóng dấu, ghi rõ họ tên)</p>
                        <div class="h-24"></div>
                        <p class="font-bold text-lg underline">VŨ ĐỨC LONG</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
