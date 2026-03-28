<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PayrollIssued extends Notification
{
    use Queueable;

    protected $payroll;

    public function __construct($payroll)
    {
        $this->payroll = $payroll;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $title = "Bạn có phiếu lương mới";
        $message = "Hệ thống đã phát hành phiếu lương cho tháng " . $this->payroll->month . "/" . $this->payroll->year . ". Số tiền thực nhận: " . number_format($this->payroll->net_salary) . " VNĐ.";

        return [
            'type' => 'payroll_issued',
            'id' => $this->payroll->id,
            'title' => $title,
            'message' => $message,
            'action_url' => route('payroll.index'),
        ];
    }
}
