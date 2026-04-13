@extends('mail-template.master')

@section('email-title')
    New Invoice Generated – {{ $invoice_number }}
@endsection

@section('subtitle')
    Against Sales Order {{ $so_number }}
@endsection

@section('content')
    <p>Dear Sir/Madam,</p>

    <p>We are pleased to inform you that an invoice has been generated for your recent order in the Vivasvanna Exports Dashboard.</p>

    <p>This invoice corresponds to the Sales Order created from your Purchase Order. You can now view full details, download the PDF, check payment status, and make payment (if applicable) directly from your client dashboard.</p>

    <div style="background: #fff3e0; border-left: 5px solid #ff9800; padding: 24px; margin: 28px 0; border-radius: 8px; font-size: 15px;">
        <strong>Invoice Details:</strong><br><br>
        
        <strong>Invoice Number :</strong> INV/{{ $invoice_number }}<br>
        <strong>Invoice Date :</strong> {{ $invoice_date }}<br>
        <strong>Related Sales Order :</strong> {{ $so_number }}<br>
        
        @if(!empty($due_date))
            <strong>Due Date :</strong> {{ $due_date }}<br>
        @endif
        @if(!empty($total_quantity))
            <strong>Total Quantity :</strong> {{ number_format($total_quantity) }} {{ $quantity_unit ?? 'units' }}<br>
        @endif    
        <strong>Total Amount :</strong> ₹{{ number_format($total_amount, 2) }}
    </div>

    <div style="text-align: center; margin: 36px 0;">
        <a href="https://portal.vivasvannaexports.com/client/invoice/list?invoice_number={{ rawurlencode($invoice_number) }}"
           style="display: inline-block; padding: 14px 40px; background-color: #ff6e40; color: #ffffff !important; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 17px;">
            View Invoice in Dashboard
        </a>
    </div>

    <p>If you need any clarification regarding the invoice amount, items, taxes, delivery, or payment process, please reach out to us at the earliest.</p>

    <p>Thank you for your continued trust and business. We value our partnership with you.</p>
@endsection