@extends('mail-template.master')

@section('email-title', 'Credit Request Update')

@section('subtitle', 'Request Not Approved')

@section('content')

<p>Dear Sir/Madam,</p>

<p>Thank you for your interest in our credit facility.</p>

<p>After careful evaluation, we regret to inform you that your <strong>credit request has not been approved at this time</strong>.</p>

<div style="background: #ffebee; border-left: 5px solid #f44336; padding: 20px; margin: 24px 0; border-radius: 6px;">
    This decision is based on our internal assessment criteria.
</div>

<p>Please don’t be discouraged — you are welcome to <strong>reapply after 3 months</strong>.</p>

<p>We encourage you to apply again in the future, and we will be happy to reassess your application.</p>

@endsection