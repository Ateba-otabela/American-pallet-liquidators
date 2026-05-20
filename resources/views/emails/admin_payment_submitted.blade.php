<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>🚨 PAYMENT PROOF SUBMITTED</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 20px; color: #1e293b; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        .header { background-color: #0f172a; padding: 30px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0; font-size: 20px; text-transform: uppercase; letter-spacing: 1px; }
        .content { padding: 30px; }
        .content h2 { font-size: 16px; margin-top: 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px; color: #0f172a; text-transform: uppercase; }
        .details-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 15px; margin-bottom: 20px; }
        .details-box p { margin: 6px 0; font-size: 13px; }
        .btn { display: inline-block; background-color: #0f172a; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 4px; font-weight: bold; font-size: 13px; text-transform: uppercase; text-align: center; }
        .footer { background-color: #f8fafc; padding: 20px; text-align: center; font-size: 11px; color: #64748b; border-top: 1px solid #e2e8f0; }
        .screenshot-container { margin-top: 20px; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px; background: #f8fafc; text-align: center; }
        .screenshot-img { max-width: 100%; max-height: 350px; border-radius: 4px; border: 1px solid #cbd5e1; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚨 PAYMENT PROOF SUBMITTED</h1>
        </div>
        
        <div class="content">
            <h2>Order Proof Details ({{ $order->order_number }})</h2>
            <p>Hello Admin,</p>
            <p>A customer has submitted transaction payment proof for their pending wholesale order. Please verify the deposit in your accounts before updating the order status to <strong>Processing</strong> or <strong>Shipped</strong>.</p>

            <div class="details-box">
                <p><strong>Customer Name:</strong> {{ $order->receiver_info['name'] }}</p>
                <p><strong>Email:</strong> {{ $order->receiver_info['email'] }}</p>
                <p><strong>Phone:</strong> {{ $order->receiver_info['phone'] }}</p>
                <p><strong>Payment Method:</strong> <span style="text-transform: uppercase; font-weight: bold;">{{ str_replace('_', ' ', $order->payment_method) }}</span></p>
                <p><strong>Transaction Ref #:</strong> <span style="font-weight: bold; font-family: monospace; background: #e2e8f0; padding: 2px 6px; border-radius: 3px; font-size: 12px;">{{ $order->transaction_reference }}</span></p>
                <p><strong>Invoice Total:</strong> <strong>${{ number_format($order->total, 2) }}</strong></p>
            </div>

            @if($order->transaction_screenshot)
                <div class="screenshot-container">
                    <p style="margin-top:0; font-size: 11px; font-weight: bold; color: #64748b; text-transform: uppercase; margin-bottom: 8px;">Uploaded Receipt Screenshot</p>
                    <a href="{{ url($order->transaction_screenshot) }}" target="_blank">
                        <img src="{{ url($order->transaction_screenshot) }}" alt="Receipt Screenshot" class="screenshot-img" />
                    </a>
                </div>
            @endif

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('admin.orders.show', $order) }}" class="btn" style="color: #ffffff;">Review Proof on Admin Panel</a>
            </div>
        </div>

        <div class="footer">
            American Pallet Liquidators LLC &bull; Automated Accounting Alerts
        </div>
    </div>
</body>
</html>
