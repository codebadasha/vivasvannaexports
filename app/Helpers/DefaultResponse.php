<?php

namespace App\Helpers;

class DefaultResponse
{
    public static function success($data = null, string $message = 'Success'): array
    {
        return [
            'status'  => true,
            'message' => $message,
            'data'    => $data,
        ];
    }

    public static function error(string $message = 'Something went wrong', $errors = []): array
    {
        return [
            'status'  => false,
            'message' => $message,
            'errors'  => $errors,
        ];
    }
}