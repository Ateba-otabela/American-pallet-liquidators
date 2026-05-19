<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Order has been Processed</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f4f5; margin: 0; padding: 20px; color: #18181b; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background-color: #09090b; padding: 30px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; letter-spacing: 1px; }
        .content { padding: 30px; }
        .content h2 { font-size: 20px; margin-top: 0; border-bottom: 1px solid #e4e4e7; padding-bottom: 10px; }
        .details-box { background: #fafafa; border: 1px solid #e4e4e7; border-radius: 6px; padding: 15px; margin-bottom: 20px; }
        .details-box p { margin: 5px 0; font-size: 14px; }
        .tracking-box { background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 6px; padding: 20px; margin-bottom: 20px; text-align: center; }
        .tracking-box h3 { color: #065f46; margin-top: 0; margin-bottom: 10px; text-transform: uppercase; font-size: 16px; }
        .tracking-number { font-size: 24px; font-weight: bold; color: #047857; margin-bottom: 15px; letter-spacing: 2px; }
        .btn { display: inline-block; background-color: #09090b; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 4px; font-weight: bold; font-size: 14px; text-transform: uppercase; }
        .items-table { w-full; border-collapse: collapse; margin-bottom: 20px; width: 100%; }
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
            <h2>Order Processed!</h2>
            <p>Hello <strong>{{ $order->receiver_info['name'] }}</strong>,</p>
            <p>Great news! Your order <strong>{{ $order->order_number }}</strong> has been processed and is preparing for shipment. Below are your tracking details and order summary.</p>

            @if($order->tracking_number)
            <div class="tracking-box">
                <h3>Your Tracking Information</h3>
                <div class="tracking-number">{{ $order->tracking_number }}</div>
                <a href="{{ $order->tracking_url ?? 'http://trockflowlogistics.com' }}" target="_blank" class="btn" style="color: #ffffff;">Track Your Shipment</a>
            </div>
            @endif

            <div class="details-box">
                <h3 style="margin-top: 0; margin-bottom: 10px; font-size: 16px;">Shipping Details</h3>
                <p><strong>Name:</strong> {{ $order->receiver_info['name'] }}</p>
                <p><strong>Address:</strong> {{ $order->receiver_info['address'] }}</p>
                <p><strong>City/State:</strong> {{ $order->receiver_info['city'] }}, {{ $order->receiver_info['state'] }} {{ $order->receiver_info['zip'] }}</p>
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
                        <td colspan="2" style="text-align: right; font-weight: bold;">Total:</td>
                        <td style="font-weight: bold;">${{ number_format($order->total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            <p style="font-size: 14px; margin-top: 30px;">Thank you for trusting American Pallet Liquidators for your wholesale needs. If you have any questions about your order, please contact our support team.</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} American Pallet Liquidators. All rights reserved.<br>
            Louisville, KY Facility
        </div>
    </div>
</body>
</html>
