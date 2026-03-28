<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeaveRequestCreated extends Notification
{
    use Queueable;

    protected $leaveRequest;

    public function __construct($leaveRequest)
    {
        $this->leaveRequest = $leaveRequest;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $employeeName = $this->leaveRequest->employee->full_name ?? 'Nhân viên';
        $startDate = date('d/m/Y', strtotime($this->leaveRequest->start_date));
        $endDate = date('d/m/Y', strtotime($this->leaveRequest->end_date));

        return [
            'type' => 'leave_request',
            'id' => $this->leaveRequest->id,
            'title' => 'Yêu cầu nghỉ phép mới',
            'message' => "Nhân viên {$employeeName} đã tạo yêu cầu nghỉ phép từ ngày {$startDate} đến ngày {$endDate}.",
            'action_url' => route('leave-requests.index', ['status' => 'Chờ duyệt']),
        ];
    }
}
