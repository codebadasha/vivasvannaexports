@extends('mail-template.master')

@section('email-title', 'Account Approved – Full Access Granted!')

@section('subtitle', 'Welcome to the Vivasvanna Exports Dashboard')

@section('content')
    <p>Dear Sir/Madam,</p>

    <p>Great news — your account has been <strong>successfully verified and approved</strong> by our team!</p>

    <div style="background: #e8f5e9; border-left: 5px solid #4caf50; padding: 20px; margin: 28px 0; border-radius: 6px; font-size: 16px; text-align: center;">
        <strong>Your full dashboard access is now active.</strong><br><br>
        You can start using the portal right away.
    </div>

    <div style="background: #f0f7ff; border: 2px dashed #1e3d59; padding: 15px 24px; margin: 32px 0; border-radius: 8px; text-align: center;">
        <h3 style="margin: 0 0 16px; color: #1e3d59;">Your Login Credentials</h3>

        <p style="font-size: 12px; margin: 16px 0;">
            <strong>Login ID / GST Number:</strong>
            <span style="font-family: monospace; background: #fff; padding: 4px 12px; border-radius: 4px; border: 1px solid #ddd;">
                {{ $gst_number }}
            </span>
        </p>

        <p style="font-size: 12px; margin: 16px 0;">
            <strong>Password:</strong>
            <span style="font-family: monospace; background: #fff; padding: 4px 12px; border-radius: 4px; border: 1px solid #ddd; color: #d32f2f;">
                {{ $password }}
            </span>
        </p>

        <p style="font-size: 14px; color: #555; margin-top: 20px;">
            <strong>Important:</strong> For security reasons, we strongly recommend changing your password after your first login.
        </p>
    </div>

    <div style="text-align: center;">
        <a href="https://portal.vivasvannaexports.com/client/login" class="btn">
            Login to Dashboard Now
        </a>
    </div>


    <p style="margin-top: 24px;">
        <strong>Quick Start Tips:</strong><br>
        • Log in using your GST number as the username/ID<br>
        • Explore sections: Purchase Orders, Invoices, E-Way Bills, etc.<br>
        • Update your profile and change password in settings<br>
        • Contact support if you face any login issues
    </p>

    <p>We’re excited to have you on board and look forward to supporting your business needs.</p>

@endsection