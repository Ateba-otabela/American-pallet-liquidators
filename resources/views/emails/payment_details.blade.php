<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Complete Your Payment for Order {{ $order->order_number }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f4f5; margin: 0; padding: 20px; color: #18181b; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background-color: #09090b; padding: 30px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; letter-spacing: 1px; }
        .content { padding: 30px; }
        .content h2 { font-size: 20px; margin-top: 0; border-bottom: 1px solid #e4e4e7; padding-bottom: 10px; }
        .details-box { background: #fafafa; border: 1px solid #e4e4e7; border-radius: 6px; padding: 15px; margin-bottom: 20px; }
        .details-box p { margin: 5px 0; font-size: 14px; }
        .payment-box { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 6px; padding: 20px; margin-bottom: 20px; text-align: left; }
        .payment-box h3 { color: #1e3a8a; margin-top: 0; margin-bottom: 10px; text-transform: uppercase; font-size: 16px; }
        .credentials { font-size: 16px; font-weight: bold; color: #1e40af; margin-bottom: 15px; white-space: pre-wrap; font-family: monospace; background: #dbeafe; padding: 10px; border-radius: 4px; }
        .btn { display: inline-block; background-color: #09090b; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 4px; font-weight: bold; font-size: 14px; text-transform: uppercase; margin-top: 15px; }
        .items-table { border-collapse: collapse; margin-bottom: 20px; width: 100%; }
        .items-table th, .items-table td { padding: 10px; text-align: left; border-bottom: 1px solid #e4e4e7; font-size: 14px; }
        .items-table th { background-color: #f4f4f5; text-transform: uppercase; font-size: 12px; color: #71717a; }
        .footer { background-color: #f4f4f5; padding: 20px; text-align: center; font-size: 12px; color: #a1a1aa; border-top: 1px solid #e4e4e7; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>American Pallet Liquidators</h1>
        </div>
        
        <div class="content">
            <h2>Payment Details Required</h2>
            <p>Hello <strong>{{ $order->receiver_info['name'] }}</strong>,</p>
            <p>Thank you for your order <strong>{{ $order->order_number }}</strong>. To process your order, please complete your offline payment using the details provided below.</p>

            <div class="payment-box">
                <h3>Pay via {{ str_replace('_', ' ', $order->payment_method) }}</h3>
                <p>Please send the exact amount of <strong>${{ number_format($order->total, 2) }}</strong> to the following details:</p>
                <div class="credentials">{{ $paymentCredentials }}</div>
                <p style="margin-top: 15px; font-size: 13px;"><em>Once you have completed the payment, please log into your account, go to your order, and submit a screenshot of your payment receipt.</em></p>
                <div style="text-align: center;">
                    <a href="{{ route('dashboard') }}" class="btn" style="color: #ffffff;">Upload Proof of Payment</a>
                </div>
            </div>

            <h3 style="font-size: 16px; border-bottom: 1px solid #e4e4e7; padding-bottom: 10px;">Order Items</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'Wholesale Pallet' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="text-align: right; font-weight: bold;">Total Due:</td>
                        <td style="font-weight: bold;">${{ number_format($order->total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            <p style="font-size: 14px; margin-top: 30px;">If you have any questions about your payment or order, please reply to this email or contact our support team.</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} American Pallet Liquidators. All rights reserved.<br>
            Louisville, KY Facility
        </div>
    </div>
</body>
</html>
