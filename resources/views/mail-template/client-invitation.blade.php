@extends('mail-template.master')

@section('email-title', 'Invitation to Join Vivasvanna Exports Dashboard')

@section('subtitle', 'Complete your registration to get started')

@section('content')
        <p>Dear Sir/Madam,</p>

        <p>You have been invited to join the <strong>Vivasvanna Exports Pvt. Ltd. Dashboard</strong>.</p>

        <p>To begin, please click the button below to complete your registration and set up your account:</p>

        <div style="text-align: center;">
            <a href="{{ $invitation_link }}" class="btn">
                Accept Invitation & Register
            </a>
        </div>

        <p style="margin-top: 24px;">
            If the button doesn't work, copy and paste this link into your browser:<br>
            <a href="{{ $invitation_link }}">{{ $invitation_link }}</a>
        </p>

        <div style="background: #fff3e0; border-left: 5px solid #ff9800; padding: 16px 20px; margin: 28px 0; border-radius: 4px;">
            <strong>Important – Next Steps:</strong><br><br>
            After registration, your account will be reviewed and verified by our team (usually within 1–2 business days).<br><br>
            You will receive a confirmation email once approved. In some cases, a team member may contact you by phone.
        </div>

        <p>Thank you for your patience — we look forward to welcoming you aboard!</p>
@endsection