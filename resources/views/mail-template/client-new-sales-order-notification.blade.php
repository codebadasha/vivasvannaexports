@extends('mail-template.master')

@section('email-title')
    New Sales Order Created – {{ $so_number }}
@endsection

@section('subtitle')
    Your Purchase Order has been Processed
@endsection

@section('content')
    <p>Dear Sir/Madam,</p>

    <p>Thank you for submitting your Purchase Order through the Vivasvanna Exports Dashboard.</p>

    <p>We have reviewed your order and created a corresponding <strong>Sales Order</strong> in our system. This Sales Order is now visible in your client dashboard for reference and tracking.</p>

    <div style="background: #e8f5e9; border-left: 5px solid #4caf50; padding: 24px; margin: 28px 0; border-radius: 8px; font-size: 15px;">
        <strong>Sales Order Details:</strong><br><br>
        
        <strong>Sales Order # :</strong> {{ $so_number }}<br>
        <strong>Order Date :</strong> {{ $order_date }}<br>
        
        @if(!empty($project_name))
            <strong>Project Name :</strong> {{ $project_name }}<br>
        @endif
        
        @if(!empty($total_quantity))
            <strong>Total Quantity :</strong> {{ number_format($total_quantity) }} {{ $quantity_unit ?? 'units' }}<br>
        @endif
        
        <strong>Total Amount :</strong> ₹{{ number_format($total_amount, 2) }}<br>
    </div>

    <p style="margin-top: 32px;">
        You can view full details, download the Sales Order PDF (if enabled), track progress, and raise related invoices directly from your dashboard.
    </p>

    <div style="text-align: center; margin: 36px 0;">
        <a href="https://portal.vivasvannaexports.com/client/po/list?order_number={{ rawurlencode($so_number) }}" style="display: inline-block; padding: 14px 40px; background-color: #ff6e40; color: #ffffff !important; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 17px;">
            View Sales Order in Dashboard
        </a>
    </div>

    <p>If you have any questions about this order, delivery timeline, payment terms, or need any clarification, please feel free to contact us.</p>

    <p>We appreciate your business and look forward to a successful partnership.</p>
@endsection