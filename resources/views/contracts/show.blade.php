@extends('layouts.app')

@section('title', 'Xem Hợp đồng - ' . $contract->contract_number)

@section('content')
<style>
    /* Styling for the contract document specifically */
    .contract-paper { 
        font-family: 'Times New Roman', Times, serif; 
        color: #000; 
        line-height: 1.6; 
        background-color: #fff;
        padding: 50px 100px;
        box-shadow: 0 0 40px rgba(0,0,0,0.05);
        border-radius: 4px;
        max-width: 1000px;
        margin: 0 auto;
    }
    .contract-container { max-width: 100%; margin: auto; }
    .header-doc { text-align: center; margin-bottom: 40px; }
    .header-doc h1 { font-size: 14pt; font-weight: bold; margin: 0; text-transform: uppercase; }
    .header-doc h2 { font-size: 12pt; font-weight: bold; margin: 5px 0 0 0; text-transform: uppercase; }
    .line-doc { border-bottom: 2px solid #000; width: 150px; margin: 10px auto; }
    .title-doc { text-align: center; margin-bottom: 30px; }
    .title-doc h3 { font-size: 16pt; font-weight: bold; text-transform: uppercase; margin: 0; }
    .title-doc p { font-style: italic; margin: 5px 0 0 0; }
    .clause-doc { margin-bottom: 20px; }
    .clause-title-doc { font-weight: bold; font-size: 12pt; margin-bottom: 5px; }
    .clause-doc p { margin: 5px 0; text-align: justify; }
    .footer-doc { margin-top: 50px; display: flex; justify-content: space-between; text-align: center; }
    .footer-doc .signature { width: 45%; }
    .footer-doc .signature h4 { margin-top: 5px; font-weight: bold; }
    .footer-doc .signature-space { height: 100px; }
    .data-field { font-weight: bold; }

    @media print {
        /* Hide everything from layout */
        aside, header, #sidebar-overlay, .sidebar-toggle, .print-btn-container {
            display: none !important;
        }
        
        html, body, .main-content, main {
            background-color: white !important;
            padding: 0 !important;
            margin: 0 !important;
            overflow: visible !important;
            height: auto !important;
        }
        
        .contract-paper {
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
            border-radius: 0 !important;
        }
        
        /* Ensure background colors are printed if any (though we want clean white) */
        * {
            -webkit-print-color-adjust: exact;
        }
    }
</style>

<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-8 print-btn-container">
        <div>
            <a href="{{ route('contracts.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-bold mb-2 transition-all group">
                <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i> Quay lại
            </a>
            <h1 class="text-3xl font-black text-slate-900">Chi tiết Hợp đồng</h1>
            <p class="text-slate-500 font-medium tracking-tight">Số hiệu: <span class="text-indigo-600 font-black tracking-widest">{{ $contract->contract_number }}</span></p>
        </div>
        <button onclick="window.print()" class="px-8 py-4 bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-600/30 hover:bg-indigo-700 transform transition-all active:scale-95 flex items-center">
            <i class="fas fa-print mr-2"></i> IN HỢP ĐỒNG
        </button>
    </div>

    <!-- The actual contract document -->
    <div class="contract-paper">
        <div class="contract-container">
            <div class="header-doc">
                <h1>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h1>
                <h2>Độc lập - Tự do - Hạnh phúc</h2>
                <div class="line-doc"></div>
                <p>Số: {{ $contract->contract_number }} / HÐLÐ</p>
            </div>

            <div class="title-doc">
                <h3>HỢP ĐỒNG LAO ĐỘNG</h3>
                <p>(Loại hợp đồng: {{ $contract->type }})</p>
            </div>

            <div class="clause-doc">
                <p>Chúng tôi, một bên là Ông/Bà: <span class="data-field">{{ \App\Models\SystemSetting::getSetting('director_name', 'VŨ ĐỨC LONG') }}</span></p>
                <p>Chức vụ: <span class="data-field">GIÁM ĐỐC</span></p>
                <p>Đại diện cho: <span class="data-field">{{ \App\Models\SystemSetting::getSetting('company_name', 'CÔNG TY TNHH PHÁT TRIỂN CÔNG NGHỆ HRM PRO') }}</span></p>
                <p>Địa chỉ: <span class="data-field">{{ \App\Models\SystemSetting::getSetting('company_address', 'Khu đô thị mới Cầu Giấy, Quận Cầu Giấy, TP. Hà Nội') }}</span></p>
                <p>Và một bên là Ông/Bà: <span class="data-field">{{ $contract->employee->full_name }}</span></p>
                <p>Ngày sinh: <span class="data-field">{{ $contract->employee->dob ? date('d/m/Y', strtotime($contract->employee->dob)) : '........' }}</span> Tại: <span class="data-field">{{ $contract->employee->pob ?? '........' }}</span></p>
                <p>Địa chỉ thường trú: <span class="data-field">{{ $contract->employee->address ?? '................' }}</span></p>
                <p>Số CCCD: <span class="data-field">{{ $contract->employee->identity_number ?? '................' }}</span> Cấp ngày: <span class="data-field">{{ $contract->employee->identity_date ? date('d/m/Y', strtotime($contract->employee->identity_date)) : '........' }}</span> Tại: <span class="data-field">{{ $contract->employee->identity_place ?? '................' }}</span></p>
            </div>

            <div class="clause-doc">
                <p class="clause-title-doc">Điều 1: Thời hạn và công việc hợp đồng</p>
                <p>- Loại hợp đồng lao động: <span class="data-field">{{ $contract->type }}</span></p>
                <p>- Thời hạn hợp đồng: Từ ngày <span class="data-field">{{ date('d/m/Y', strtotime($contract->start_date)) }}</span> đến ngày <span class="data-field">{{ $contract->end_date ? date('d/m/Y', strtotime($contract->end_date)) : 'Vô thời hạn' }}</span></p>
                <p>- Chức danh chuyên môn: <span class="data-field">{{ $contract->employee->position->name ?? 'Nhân viên' }}</span></p>
            </div>

            <div class="clause-doc">
                <p class="clause-title-doc">Điều 2: Chế độ làm việc</p>
                <p>- Thời gian làm việc: <span class="data-field">{{ $contract->working_time ?? \App\Models\SystemSetting::getSetting('default_working_time', '08 giờ/ngày (48 giờ/tuần)') }}</span></p>
                <p>- Dụng cụ làm việc: <span class="data-field">Được cấp phát theo quy định của Công ty</span></p>
            </div>

            <div class="clause-doc">
                <p class="clause-title-doc">Điều 3: Nghĩa vụ và quyền lợi của người lao động</p>
                <p><b>1. Quyền lợi:</b></p>
                <p>- Mức lương chính thức: <span class="data-field">{{ number_format($contract->salary_amount > 0 ? $contract->salary_amount : ($contract->employee->position->basic_salary ?? 0)) }} VNĐ</span></p>
                @if($contract->probation_salary)
                <p>- Mức lương thử việc: <span class="data-field">{{ number_format($contract->probation_salary) }} VNĐ</span></p>
                @endif
                <p>- Phụ cấp & thỏa thuận khác: <span class="data-field">{{ $contract->allowances_text ?? 'Theo quy định công ty' }}</span></p>
                <p>- Hình thức trả lương: Chuyển khoản ngân hàng ({{ $contract->employee->bank_name ?? '........' }} - STK: {{ $contract->employee->bank_account ?? '........' }})</p>
                <p>- Các quyền lợi về BHXH, BHYT: Theo quy định pháp luật (Số BHXH: {{ $contract->employee->social_insurance_number ?? '........' }} - Mã số thuế: {{ $contract->employee->tax_code ?? '........' }})</p>
                <p><b>2. Nghĩa vụ:</b></p>
                <p>- Hoàn thành những công việc đã cam kết trong hợp đồng lao động này.</p>
                <p>- Chấp hành nội quy, kỷ luật lao động, an toàn lao động và các quy định của doanh nghiệp.</p>
            </div>

            <div class="clause-doc">
                <p class="clause-title-doc">Điều 4: Điều khoản chung</p>
                <p>- Hợp đồng này có hiệu lực kể từ ngày ký. Những vấn đề không ghi trong hợp đồng này sẽ được thực hiện theo quy định của pháp luật lao động hiện hành.</p>
            </div>

            <div class="clause-doc">
                <p>Hợp đồng này được lập thành 02 bản có giá trị pháp lý như nhau, mỗi bên giữ 01 bản.</p>
                <p>Làm tại TP. Hà Nội, ngày <span class="data-field">{{ $contract->created_at->format('d') }}</span> tháng <span class="data-field">{{ $contract->created_at->format('m') }}</span> năm <span class="data-field">{{ $contract->created_at->format('Y') }}</span>.</p>
            </div>

            <div class="footer-doc">
                <div class="signature">
                    <h4>NGƯỜI LAO ĐỘNG</h4>
                    <p>(Ký, ghi rõ họ tên)</p>
                    <div class="signature-space"></div>
                    <p><b>{{ $contract->employee->full_name }}</b></p>
                </div>
                <div class="signature">
                    <h4>NGƯỜI SỬ DỤNG LAO ĐỘNG</h4>
                    <p>(Ký, ghi rõ họ tên, đóng dấu)</p>
                    <div class="signature-space"></div>
                    <p><b>{{ \App\Models\SystemSetting::getSetting('director_name', 'VŨ ĐỨC LONG') }}</b></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
