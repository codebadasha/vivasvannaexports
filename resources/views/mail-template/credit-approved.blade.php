@extends('mail-template.master')

@section('email-title', 'Credit Approved 🎉')

@section('subtitle', 'Congratulations! Your credit is Approved')

@section('content')

<p>Dear Sir/Madam,</p>

<p>We are pleased to inform you that your <strong>credit request has been approved</strong>.</p>

<div style="background: #e8f5e9; border-left: 5px solid #4caf50; padding: 20px; margin: 24px 0; border-radius: 6px;">
    <strong>Your credit facility is now Approved.</strong><br><br>
    You can start using it as per your business requirements.
</div>

<p>For any future enhancement of your credit limit, you may apply again after <strong>6 months</strong>.</p>

<p>We look forward to supporting your business growth 🚀</p>

@endsection