@extends('mail-template.master')

@section('email-title', 'Credit Request Update')

@section('subtitle', 'Request Cancelled Due to Technical Issue')

@section('content')

<p>Dear Sir/Madam,</p>

<p>We regret to inform you that your recent <strong>credit request</strong> could not be processed successfully due to a temporary technical issue while retrieving your financial data.</p>

<div style="background: #fff3e0; border-left: 5px solid #ff9800; padding: 20px; margin: 24px 0; border-radius: 6px;">
    <strong>Reason:</strong><br><br>
    There was an issue while fetching your bank statement / GST report from the source system.
</div>

<p>Please don’t worry — this is not related to your eligibility.</p>

<p>You may reapply for credit at your convenience. We recommend trying again after some time once the issue is resolved.</p>

<p>If the issue persists, feel free to contact our support team for assistance.</p>

@endsection