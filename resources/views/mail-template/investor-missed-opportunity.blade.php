@extends('mail-template.master')

@section('email-title')
    Investment Opportunity Closed
@endsection

@section('subtitle')
    Previously Available Invoice(s) Are No Longer Open
@endsection

@section('content')
    <p>Dear Investor,</p>

    <p>The following invoice(s), which were available for funding, have now been allocated to another investor:</p>

    <div style="background: #fff3e0; border-left: 5px solid #ff9800; padding: 20px; margin: 28px 0; border-radius: 8px;">

        <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse;">
            <thead>
                <tr style="background-color: #ff9800; color: #ffffff;">
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
    </div>

    <p>
        These opportunities are no longer available for funding.
    </p>

    <div style="text-align: center; margin: 36px 0;">
        <a href="https://portal.vivasvannaexports.com/investor/invoice/list"
           style="display: inline-block; padding: 14px 40px; background-color: #1e3d59; color: #ffffff !important; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 17px;">
            Explore Other Available Opportunities
        </a>
    </div>

    <p>Stay tuned — new investment opportunities are added regularly.</p>
@endsection