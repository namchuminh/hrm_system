<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LeaveStatusUpdated extends Notification
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
        $statusLabel = $this->leaveRequest->status;
        $title = "Đơn nghỉ phép của bạn đã được {$statusLabel}";
        $message = "Yêu cầu nghỉ phép từ ngày " . date('d/m/Y', strtotime($this->leaveRequest->start_date)) . " đến ngày " . date('d/m/Y', strtotime($this->leaveRequest->end_date)) . " đã được cập nhật thành: {$statusLabel}.";

        return [
            'type' => 'leave_status',
            'id' => $this->leaveRequest->id,
            'title' => $title,
            'message' => $message,
            'action_url' => route('leave-requests.index'),
        ];
    }
}
