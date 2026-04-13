@extends('mail-template.master')

@section('email-title', 'Credit Request Submitted')

@section('subtitle', 'Your request is under review')

@section('content')

<p>Dear Sir/Madam,</p>

<p>Thank you for submitting your <strong>credit request</strong> with Vivasvanna Exports.</p>

<div style="background: #e3f2fd; border-left: 5px solid #2196f3; padding: 20px; margin: 24px 0; border-radius: 6px;">
    <strong>Status:</strong> Under Review<br><br>
    Our team is currently evaluating your application and verifying the submitted details.
</div>

<p><strong>Expected timeline:</strong> 1–2 business days.</p>

<p>You will receive another email once your request is approved or if any additional information is required.</p>

@endsection