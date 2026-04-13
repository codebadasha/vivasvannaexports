@extends('mail-template.master')

@section('email-title')
    {{ count($invoices) }} New Invoice(s) Assigned to You
@endsection

@section('subtitle')
    Investment Allocation Notification
@endsection

@section('content')
    <p>Dear Investor,</p>

    <p>The following invoice(s) have been assigned to your account for funding:</p>

    <div style="background: #f0f7ff; border-left: 5px solid #1e3d59; padding: 20px; margin: 28px 0; border-radius: 8px;">

        <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse;">
            <thead>
                <tr style="background-color: #1e3d59; color: #ffffff;">
                    <th align="left">Invoice No</th>
                    <th align="left">Client</th>
                    <th align="left">Due Date</th>
                    <th align="right">Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td>{{ $invoice['invoice_number'] }}</td>
                        <td>{{ $invoice['client_name'] }}</td>
                        <td>{{ $invoice['due_date'] ?? 'N/A' }}</td>
                        <td align="right">{{ number_format($invoice['total_amount'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px; font-weight: bold; text-align: right;">
            Total Investment Value: ₹{{ number_format($total_amount, 2) }}
        </div>
    </div>

    <div style="text-align: center; margin: 36px 0;">
        <a href="https://portal.vivasvannaexports.com/investor-panel/invoice/list"
           style="display: inline-block; padding: 14px 40px; background-color: #1e3d59; color: #ffffff !important; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 17px;">
            View in Investor Dashboard
        </a>
    </div>

    <p>Please review and proceed as per your investment terms.</p>
@endsection