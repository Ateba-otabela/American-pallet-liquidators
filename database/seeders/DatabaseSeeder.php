<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed users
        User::updateOrCreate(
            ['email' => 'admin@aplpallets.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@aplpallets.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );

        // Seed categories
        $pallets = Category::updateOrCreate(
            ['slug' => 'pallets'],
            ['name' => 'Pallets']
        );

        $truckloads = Category::updateOrCreate(
            ['slug' => 'truckloads'],
            ['name' => 'Truckloads']
        );

        // Seed products
        $products = [
            [
                'name' => 'Amazon High Count Liquidation Pallet',
                'slug' => 'amazon-high-count-liquidation-pallet',
                'description' => 'This Amazon high piece count liquidation pallet is loaded with untouched merchandise direct from Amazon fulfillment centers. Perfect for bin stores, eBay resellers, and flea markets. Contains a premium mix of electronics, housewares, home decor, toys, and small tools. Extremely high piece counts!',
                'price' => 699.00,
                'original_price' => 899.00,
                'badge' => 'sold_out',
                'category_id' => $pallets->id,
                'stock' => 0,
                'images' => ['/images/products/amazon_pallet_1779157693415.png'],
            ],
            [
                'name' => 'Apparel Liquidation Pallet',
                'slug' => 'apparel-liquidation-pallet',
                'description' => 'Premium apparel liquidation pallets containing shelf pulls, overstock, and customer returns from top national retail brands. Includes mixed styles of men\'s, women\'s, and children\'s clothing, activewear, and outerwear. Brands vary and range from budget-friendly to high-end apparel.',
                'price' => 629.00,
                'original_price' => 799.00,
                'badge' => 'sale',
                'category_id' => $pallets->id,
                'stock' => 12,
                'images' => ['/images/products/apparel_pallet_1779157738046.png'],
            ],
            [
                'name' => 'Premium Health & Beauty Aid (HBA) Pallets',
                'slug' => 'premium-health-beauty-aid-hba-pallets',
                'description' => 'Untouched premium Health and Beauty Aid (HBA) pallets direct from major pharmacy and retail chains. Contains shelf pulls and overstock cosmetics, skincare, hair care, personal hygiene products, vitamins, OTC medicines, and daily essentials. Outstanding retail values!',
                'price' => 1799.00,
                'original_price' => null,
                'badge' => null,
                'category_id' => $pallets->id,
                'stock' => 8,
                'images' => ['/images/products/hba_pallet_1779157750699.png'],
            ],
            [
                'name' => 'Target "MONSTERS" Truckload',
                'slug' => 'target-monsters-truckload',
                'description' => 'Target "MONSTERS" Truckloads consist of huge bulk general merchandise, bulky items, furniture, patio sets, large housewares, sporting goods, toys, and mixed home goods. These are uninspected customer return loads with immense retail value. Usually 24 to 26 tall pallets.',
                'price' => 14000.00,
                'original_price' => 16000.00,
                'badge' => 'sale',
                'category_id' => $truckloads->id,
                'stock' => 2,
                'images' => ['/images/products/target_monsters_1779157950610.png'],
            ],
            [
                'name' => 'Target Bedding Truckload',
                'slug' => 'target-bedding-truckload',
                'description' => 'Target bedding and home textile truckloads containing sheets, comforters, pillows, blankets, mattress pads, rugs, and decorative pillows. Comprised of shelf pulls, overstock, and minor customer returns. Incredibly clean loads!',
                'price' => 7500.00,
                'original_price' => null,
                'badge' => null,
                'category_id' => $truckloads->id,
                'stock' => 3,
                'images' => ['/images/products/target_bedding_1779157985288.png'],
            ],
            [
                'name' => 'TGT Case Pack Truckload',
                'slug' => 'tgt-case-pack-truckload',
                'description' => 'Highly coveted case pack general merchandise truckloads. These items are brand new, master carton case pack products from Target warehouses. No customer returns! Extremely easy to process and perfect for retail shelves, discount stores, or online marketplaces.',
                'price' => 6500.00,
                'original_price' => 9500.00,
                'badge' => 'sale',
                'category_id' => $truckloads->id,
                'stock' => 4,
                'images' => ['/images/products/tgt_case_pack_1779158113011.png'],
            ],
            [
                'name' => 'TGT General Merchandise Truckload',
                'slug' => 'tgt-general-merchandise-truckload',
                'description' => 'Target high-quality general merchandise truckloads containing 24 tall pallets of mixed category items: electronics, small appliances, toys, kitchenware, home decor, sporting goods, and more. Clean customer returns and overstocks with huge profit margins.',
                'price' => 11500.00,
                'original_price' => 12500.00,
                'badge' => 'sale',
                'category_id' => $truckloads->id,
                'stock' => 1,
                'images' => ['/images/products/tgt_general_merch_1779158127509.png'],
            ],
            [
                'name' => 'USPS High Piece Count Truckload',
                'slug' => 'usps-high-piece-count-truckload',
                'description' => 'Extremely popular USPS high piece count truckload containing undeliverable mail parcels, lost mail packages, overstocks, and unclaimed consumer orders. Excellent assortment of mixed retail goods, gadgets, accessories, clothing, and unique finds. Sell the packages individually or process them for maximum profits!',
                'price' => 14000.00,
                'original_price' => 15000.00,
                'badge' => 'sale',
                'category_id' => $truckloads->id,
                'stock' => 2,
                'images' => ['/images/products/usps_high_piece_count_1779158200000.png'],
            ],
            [
                'name' => 'Clearance Home Goods Pallet',
                'slug' => 'clearance-home-goods-pallet',
                'description' => 'A clearance pallet packed with gently used and overstock home goods: kitchen gadgets, linens, bedding, decor, craft supplies, and small furniture pieces. Ideal for home stores, thrift sellers, and liquidation resellers.',
                'price' => 899.00,
                'original_price' => 1299.00,
                'badge' => 'sale',
                'category_id' => $pallets->id,
                'stock' => 7,
                'images' => ['/images/products/clearance_home_goods_1779158250000.png'],
            ],
            [
                'name' => 'Electronics Overstock Pallet',
                'slug' => 'electronics-overstock-pallet',
                'description' => 'A high-value electronics overstock pallet loaded with headphones, chargers, smart home accessories, phone cases, batteries, computer peripherals, and streaming devices. Great for online marketplaces and tech resellers.',
                'price' => 1199.00,
                'original_price' => 1699.00,
                'badge' => 'sale',
                'category_id' => $pallets->id,
                'stock' => 5,
                'images' => ['/images/products/electronics_overstock_1779158300000.png'],
            ],
            [
                'name' => 'Mixed Electronics Bulk Pallet',
                'slug' => 'mixed-electronics-bulk-pallet',
                'description' => 'A pallet packed with mixed consumer electronics and accessories including headphones, chargers, cables, tablets, smart home gadgets, and small appliances. Perfect for tech resale, refurbishing, and online marketplaces.',
                'price' => 1049.00,
                'original_price' => 1399.00,
                'badge' => 'sale',
                'category_id' => $pallets->id,
                'stock' => 6,
                'images' => ['/images/products/mixed_electronics_bulk_1779158400000.png'],
            ],
            [
                'name' => 'Home Decor Overstock Pallet',
                'slug' => 'home-decor-overstock-pallet',
                'description' => 'A carefully curated overstock pallet of home decor items including wall art, mirrors, candles, decorative accents, frames, and small furniture pieces. Ideal for home stores and wholesale buyers.',
                'price' => 749.00,
                'original_price' => 999.00,
                'badge' => null,
                'category_id' => $pallets->id,
                'stock' => 9,
                'images' => ['/images/products/home_decor_overstock_1779158450000.png'],
            ],
            [
                'name' => 'Mixed Return Truckload',
                'slug' => 'mixed-return-truckload',
                'description' => 'A large truckload of mixed customer returns and overstocks featuring apparel, housewares, toys, electronics, and seasonal merchandise. Great for resellers and liquidation buyers seeking variety and high volume.',
                'price' => 9200.00,
                'original_price' => 11800.00,
                'badge' => 'sale',
                'category_id' => $truckloads->id,
                'stock' => 3,
                'images' => ['/images/products/mixed_return_truckload_1779158500000.png'],
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['slug' => $p['slug']], $p);
        }

        // Seed settings
        $settings = [
            'site_name' => 'American Pallet Liquidators',
            'contact_email' => 'americanpalletliquidators0@gmail.com',
            'contact_phone' => '+44 7882 769759',
            'bank_name' => 'Chase Bank',
            'bank_account_name' => 'American Pallet Liquidators LLC',
            'bank_routing_number' => '123456789',
            'bank_account_number' => '9876543210',
            'cash_app_cashtag' => '$aplpallets',
            'zelle_email' => 'zelle@aplpallets.com',
            'USDT_address' => '0x1234567890abcdef1234567890abcdef12345678',
            'venmo_handle' => '@aplpallets',
            'paypal_email' => 'paypal@aplpallets.com',
            'stripe_publishable_key' => 'pk_test_placeholder',
            'stripe_secret_key' => 'sk_test_placeholder',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
