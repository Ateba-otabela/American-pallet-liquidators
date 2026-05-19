<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>🚨 NEW SALES ORDER RECEIVED</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #fffbeb; margin: 0; padding: 20px; color: #1c1917; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(120,53,4,0.08); border: 1px solid #fef3c7; }
        .header { background-color: #78350f; padding: 30px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0; font-size: 22px; text-transform: uppercase; letter-spacing: 1px; }
        .content { padding: 30px; }
        .content h2 { font-size: 18px; margin-top: 0; border-bottom: 2px solid #fef3c7; padding-bottom: 10px; color: #78350f; }
        .details-box { background: #fffdf5; border: 1px solid #fef3c7; border-radius: 6px; padding: 15px; margin-bottom: 20px; }
        .details-box p { margin: 5px 0; font-size: 14px; }
        .items-table { border-collapse: collapse; margin-bottom: 20px; width: 100%; }
        .items-table th, .items-table td { padding: 10px; text-align: left; border-bottom: 1px solid #fef3c7; font-size: 14px; }
        .items-table th { background-color: #fef3c7; text-transform: uppercase; font-size: 12px; color: #78350f; font-weight: 800; }
        .btn { display: inline-block; background-color: #78350f; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 4px; font-weight: bold; font-size: 14px; text-transform: uppercase; text-align: center; }
        .footer { background-color: #fffdf5; padding: 20px; text-align: center; font-size: 12px; color: #78350f; border-top: 1px solid #fef3c7; opacity: 0.8; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚨 NEW ORDER PLACED</h1>
        </div>
        
        <div class="content">
            <h2>Order Details ({{ $order->order_number }})</h2>
            <p>Hello Admin,</p>
            <p>A new wholesale order has been submitted. Here are the order and customer details:</p>

            <div class="details-box">
                <h3 style="margin-top: 0; margin-bottom: 10px; font-size: 15px; color: #78350f;">Customer Details</h3>
                <p><strong>Name:</strong> {{ $order->receiver_info['name'] }}</p>
                <p><strong>Company:</strong> {{ $order->receiver_info['company'] ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $order->receiver_info['email'] }}</p>
                <p><strong>Phone:</strong> {{ $order->receiver_info['phone'] }}</p>
                <p><strong>Payment Method:</strong> <span style="text-transform: uppercase; font-weight: bold;">{{ str_replace('_', ' ', $order->payment_method) }}</span></p>
                @if($order->payment_intent_id)
                    <p><strong>Reference/Intent:</strong> {{ str_replace('Offline Ref: ', '', $order->payment_intent_id) }}</p>
                @endif
            </div>

            <div class="details-box">
                <h3 style="margin-top: 0; margin-bottom: 10px; font-size: 15px; color: #78350f;">Shipping Address</h3>
                <p>{{ $order->receiver_info['address'] }}</p>
                <p>{{ $order->receiver_info['city'] }}, {{ $order->receiver_info['state'] }} {{ $order->receiver_info['zip'] }}</p>
            </div>

            <h3 style="font-size: 15px; border-bottom: 1px solid #fef3c7; padding-bottom: 5px; color: #78350f;">Order Summary</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Lot Name</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'Wholesale Lot' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="text-align: right; font-weight: bold; color: #78350f;">Total Revenue:</td>
                        <td style="font-weight: bold; color: #78350f;">${{ number_format($order->total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('admin.orders.show', $order) }}" class="btn" style="color: #ffffff;">Manage Order on Dashboard</a>
            </div>
        </div>

        <div class="footer">
            American Pallet Liquidators LLC &bull; Admin Notifications
        </div>
    </div>
</body>
</html>
