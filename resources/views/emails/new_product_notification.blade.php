<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>📦 NEW WHOLESALE LOT IN STOCK</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #fafafa; margin: 0; padding: 20px; color: #18181b; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #e4e4e7; }
        .header { background-color: #09090b; padding: 30px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0; font-size: 20px; text-transform: uppercase; letter-spacing: 1px; }
        .content { padding: 30px; }
        .content h2 { font-size: 22px; margin-top: 0; color: #09090b; font-weight: 800; text-transform: uppercase; letter-spacing: -0.5px; }
        .price-tag { font-size: 24px; font-weight: 900; color: #16a34a; margin: 15px 0; }
        .original-price { font-size: 16px; font-weight: 600; color: #a1a1aa; text-decoration: line-through; margin-left: 10px; }
        .product-image { width: 100%; max-height: 350px; object-fit: cover; border-radius: 6px; margin: 20px 0; border: 1px solid #e4e4e7; }
        .description { font-size: 14px; line-height: 1.6; color: #52525b; margin-bottom: 25px; }
        .details-list { background-color: #f4f4f5; border-radius: 6px; padding: 15px; margin-bottom: 25px; list-style: none; padding-left: 0; }
        .details-list li { font-size: 13px; font-weight: bold; margin-bottom: 8px; color: #27272a; }
        .details-list li span { color: #71717a; font-weight: normal; }
        .btn { display: block; background-color: #09090b; color: #ffffff; text-decoration: none; padding: 14px 24px; border-radius: 4px; font-weight: bold; font-size: 14px; text-transform: uppercase; text-align: center; margin: 30px 0; }
        .footer { background-color: #f4f4f5; padding: 20px; text-align: center; font-size: 11px; color: #a1a1aa; border-top: 1px solid #e4e4e7; }
        .footer a { color: #71717a; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Inventory Alert</h1>
        </div>
        
        <div class="content">
            <span style="font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px; color: #ef4444; display: block; margin-bottom: 5px;">Just Liquidated</span>
            <h2>{{ $product->name }}</h2>
            
            <div class="price-tag">
                ${{ number_format($product->price, 2) }}
                @if($product->original_price)
                    <span class="original-price">${{ number_format($product->original_price, 2) }}</span>
                @endif
            </div>

            @if($product->first_image_url)
                <img src="{{ url($product->first_image_url) }}" alt="{{ $product->name }}" class="product-image" />
            @endif

            <div class="description">
                {{ Str::limit(strip_tags($product->description), 250) }}
            </div>

            <ul class="details-list">
                <li>Category: <span>{{ $product->category->name ?? 'Wholesale Lots' }}</span></li>
                <li>Stock Availability: <span>{{ $product->stock }} Lot(s)</span></li>
                @if($product->badge)
                    <li>Highlight: <span style="text-transform: uppercase; font-weight: 800; color: #ef4444;">{{ $product->badge }}</span></li>
                @endif
            </ul>

            <a href="{{ route('products.show', $product->slug) }}" class="btn" style="color: #ffffff;">View & Buy Lot Online</a>
        </div>

        <div class="footer">
            You received this email because you subscribed to inventory updates from American Pallet Liquidators.<br>
            Louisville, KY Facility &bull; <a href="{{ url('/') }}">Visit Our Storefront</a>
        </div>
    </div>
</body>
</html>
