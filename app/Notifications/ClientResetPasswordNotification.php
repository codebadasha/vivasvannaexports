<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use App\Helpers\MailHelper;

class ClientResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
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
            $resetUrl = url('/client/password/reset/'.$this->token.'?email='.$notifiable->email);
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
                Log::error("Client Reset Password mail failed for {$notifiable->email}: " . $response['message']);
            } else {
                Log::info("Client Reset Password mail sent to {$notifiable->email}");
            }

        } catch (\Throwable $e) {
            Log::error("Client Reset Password mail error: " . $e->getMessage());
        }
    }
    
}
