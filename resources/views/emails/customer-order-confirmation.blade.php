<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Thank you for your order!</h2>
    <p>Hi {{ $order->receiver_info['name'] ?? 'Customer' }},</p>
    <p>We've received your order and we're getting it ready.</p>
    
    <h3>Order Summary</h3>
    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
    <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
    <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>

    <h3>Shipping Address</h3>
    <p>
        {{ $order->receiver_info['address'] }}<br>
        {{ $order->receiver_info['city'] }}, {{ $order->receiver_info['state'] }} {{ $order->receiver_info['zip'] }}
    </p>

    <h3>Items</h3>
    <ul>
        @foreach($order->items as $item)
            <li>{{ $item->product->name }} x {{ $item->quantity }} - ${{ number_format($item->price, 2) }}</li>
        @endforeach
    </ul>

    <p>If you have any questions, feel free to reply to this email.</p>
    <p>Best regards,<br>American Pallet Liquidators</p>
</body>
</html>
