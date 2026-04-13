@extends('mail-template.master')

@section('email-title', 'Password Reset Request')

@section('subtitle', 'Secure access to Panel')

@section('content')
    <p>Dear Sir/Madam,</p>

    <p>We received a request to reset your <strong>Vivasvanna Exports Dashboard</strong> password.</p>

    <div style="background: #fff3e0; border-left: 5px solid #ff9800; padding: 20px; margin: 24px 0; border-radius: 6px;">
        <strong>Action Required</strong><br>
        Click the button below to reset your password securely.
    </div>

    <div style="text-align: center;">
        <a href="{{ $reset_url }}"
            style="display: inline-block; padding: 14px 40px; background-color: #ff6e40; color: #ffffff !important; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 17px;">
                Reset Password
            </a>
        
    </div>

    <p style="margin-top:20px;">
        This link will expire in <strong>60 minutes</strong>.
    </p>

    <p>
        If you did not request a password reset, please ignore this email or contact support immediately.
    </p>
@endsection