@extends('mail-template.master')

@section('email-title', 'Registration Successful – Awaiting Verification')

@section('subtitle', 'Thank you for joining Vivasvanna Exports')

@section('content')
    <p>Dear Sir/Madam,</p>

    <p>Thank you for completing your registration with the <strong>Vivasvanna Exports Dashboard</strong>.</p>

    <div style="background: #e8f5e9; border-left: 5px solid #4caf50; padding: 20px; margin: 24px 0; border-radius: 6px; font-size: 15px;">
        <strong>Your account has been successfully created!</strong><br><br>
        We have received your details and your account is now under review.
    </div>

    <div style="background: #fff3e0; border-left: 5px solid #ff9800; padding: 20px; margin: 24px 0; border-radius: 6px;">
        <strong>Current Status: Awaiting Verification</strong><br><br>
        Full access to the portal will be granted only after manual verification and approval.<br><br>
        <strong>Expected time:</strong> Usually 1–2 business days.<br><br>
        Once approved, you will receive a <strong>confirmation email</strong> with full access instructions.<br>
        A team member may also contact you by phone if needed.
    </div>

    <p style="margin-top: 28px;">
        You can bookmark the login page for later:<br>
        <a href="https://portal.vivasvannaexports.com/client/login">https://portal.vivasvannaexports.com/client/login</a>
    </p>

    <p>If you have any questions in the meantime, please feel free to reach out.</p>
@endsection