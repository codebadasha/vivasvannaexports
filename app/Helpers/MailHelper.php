<?php

namespace App\Helpers;

use App\Mail\CommonMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MailHelper
{
    /**
     * Send a mail anywhere with blade template, CC, attachments.
     *
     * @param string|array $to
     * @param string $subject
     * @param string $viewFile
     * @param array $data
     * @param array $cc
     * @param array $attachments
     */
    public static function send($to, $subject, $viewFile, $data = [], $cc = [], $attachments = [])
    {
        try {
            Mail::to($to)->send(new CommonMail($data, $viewFile, $subject, $cc, $attachments));

            return [
                'status' => true,
                'message' => 'Mail sent successfully',
                'to' => $to,
                'cc' => $cc
            ];
        } catch (\Exception $e) {
            // Log the error
            Log::error('Mail failed to send', [
                'to' => $to,
                'cc' => $cc,
                'subject' => $subject,
                'error' => $e->getMessage()
            ]);

            return [
                'status' => false,
                'message' => 'Mail failed: ' . $e->getMessage(),
                'to' => $to,
                'cc' => $cc
            ];
        }
    }
}
