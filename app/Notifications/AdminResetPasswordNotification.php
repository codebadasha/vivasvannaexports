<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use App\Helpers\MailHelper;

class AdminResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return [];
    }

    public function toMail($notifiable)
    {
        // not used
    }

    public function sendCustomMail($notifiable)
    {
        try {
            $resetUrl = url('/admin/password/reset/'.$this->token.'?email='.$notifiable->email);

            $subject = 'Reset Your Password';
            $viewFile = 'mail-template.admin-reset-password';

            $data = [
                'reset_url' => $resetUrl,
                'email' => $notifiable->email
            ];

            $response = MailHelper::send(
                $notifiable->email,
                // 'jay.ladani003@gmail.com',
                $subject,
                $viewFile,
                $data
            );

            if (!$response['status']) {
                Log::error("Admin Reset Password mail failed for {$notifiable->email}: " . $response['message']);
            } else {
                Log::info("Admin Reset Password mail sent to {$notifiable->email}");
            }

        } catch (\Throwable $e) {
            Log::error("Admin Reset Password mail error: " . $e->getMessage());
        }
    }
}