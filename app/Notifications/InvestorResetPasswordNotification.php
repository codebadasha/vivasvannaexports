<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use App\Helpers\MailHelper;

class InvestorResetPasswordNotification extends Notification
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
            $reseturl = url('/investor-panel/password/reset/'.$this->token.'?email='.$notifiable->email);
            $subject = 'Reset Your Password';
            $viewFile = 'mail-template.admin-reset-password';

            $data = [
                'reset_url' => $resetUrl,
                'email' => $notifiable->email
            ];

            $response = MailHelper::send(
                $notifiable->email,
                $subject,
                $viewFile,
                $data
            );

            if (!$response['status']) {
                Log::error("Investor Reset Password mail failed for {$notifiable->email}: " . $response['message']);
            } else {
                Log::info("Investor Reset Password mail sent to {$notifiable->email}");
            }

        } catch (\Throwable $e) {
            Log::error("Investor Reset Password mail error: " . $e->getMessage());
        }
    }
}