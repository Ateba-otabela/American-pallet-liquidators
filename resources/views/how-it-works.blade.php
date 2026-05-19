@extends('layouts.ecommerce')

@section('title', 'How It Works — Purchasing Liquidation Merchandise')

@section('content')
    <!-- Header -->
    <section class="bg-white border-b border-gray-200 py-16 text-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-zinc-500 text-xs font-extrabold uppercase tracking-widest block mb-2">Reseller Starter Guide</span>
            <h1 class="text-3xl sm:text-5xl font-black text-zinc-950 uppercase tracking-tight mb-4">How Wholesale Purchasing Works</h1>
            <p class="text-slate-500 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">Buying wholesale liquidated merchandise is simple and highly lucrative. Follow our 5-step process to secure stock and scale your reselling business.</p>
        </div>
    </section>

    <!-- 5 Steps Timeline -->
    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="space-y-16 relative">
            
            <!-- Connector Line (Desktop) -->
            <div class="hidden md:block absolute left-1/2 top-0 bottom-0 w-0.5 bg-gray-200 transform -translate-x-1/2 z-0"></div>

            <!-- Step 1 -->
            <div class="flex flex-col md:flex-row gap-8 items-center relative z-10">
                <div class="w-full md:w-1/2 flex justify-start md:justify-end md:pr-12">
                    <span class="bg-zinc-950 text-white font-black text-3xl sm:text-4xl h-16 w-16 sm:h-20 sm:w-20 rounded-full flex items-center justify-center shadow-lg border-4 border-white">01</span>
                </div>
                <div class="w-full md:w-1/2 bg-white border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm">
                    <span class="text-zinc-400 text-[10px] font-bold uppercase tracking-widest block mb-1">Step One</span>
                    <h3 class="text-xl font-extrabold text-zinc-950 uppercase tracking-tight mb-3">Browse &amp; Select Lots</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Browse our real-time catalog of liquidated pallets and truckloads. We source products directly from major pharmacy chains, online e-commerce networks, and top national department stores. Check the piece count, stock availability, and badge indicators to select the right merchandise for your store.</p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="flex flex-col md:flex-row gap-8 items-center relative z-10">
                <div class="w-full md:w-1/2 order-1 md:order-2 flex justify-start md:pl-12">
                    <span class="bg-zinc-950 text-white font-black text-3xl sm:text-4xl h-16 w-16 sm:h-20 sm:w-20 rounded-full flex items-center justify-center shadow-lg border-4 border-white">02</span>
                </div>
                <div class="w-full md:w-1/2 order-2 md:order-1 bg-white border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm">
                    <span class="text-zinc-400 text-[10px] font-bold uppercase tracking-widest block mb-1">Step Two</span>
                    <h3 class="text-xl font-extrabold text-zinc-950 uppercase tracking-tight mb-3">Add to Cart &amp; Checkout</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Add the selected lots to your shopping cart. Fill in your billing and shipping/receiver details in Step 1 of checkout. Our checkout securely handles high-value wholesale transactions and protects your customer data.</p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="flex flex-col md:flex-row gap-8 items-center relative z-10">
                <div class="w-full md:w-1/2 flex justify-start md:justify-end md:pr-12">
                    <span class="bg-zinc-950 text-white font-black text-3xl sm:text-4xl h-16 w-16 sm:h-20 sm:w-20 rounded-full flex items-center justify-center shadow-lg border-4 border-white">03</span>
                </div>
                <div class="w-full md:w-1/2 bg-white border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm">
                    <span class="text-zinc-400 text-[10px] font-bold uppercase tracking-widest block mb-1">Step Three</span>
                    <h3 class="text-xl font-extrabold text-zinc-950 uppercase tracking-tight mb-3">Choose Your Payment Method</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">We support 8 flexible payment methods. Select Zelle, Wire Transfer, Venmo, Cash App, PayPal, USDT crypto, or pay with your debit/credit card via secure Stripe Elements. You can also select "Cash on Pickup" to pay cash in person when you pick up at our warehouse.</p>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="flex flex-col md:flex-row gap-8 items-center relative z-10">
                <div class="w-full md:w-1/2 order-1 md:order-2 flex justify-start md:pl-12">
                    <span class="bg-zinc-950 text-white font-black text-3xl sm:text-4xl h-16 w-16 sm:h-20 sm:w-20 rounded-full flex items-center justify-center shadow-lg border-4 border-white">04</span>
                </div>
                <div class="w-full md:w-1/2 order-2 md:order-1 bg-white border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm">
                    <span class="text-zinc-400 text-[10px] font-bold uppercase tracking-widest block mb-1">Step Four</span>
                    <h3 class="text-xl font-extrabold text-zinc-950 uppercase tracking-tight mb-3">Schedule Warehouse Pickup or Ship</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Once payment is completed or order is submitted, contact us to schedule free dock loading at our Louisville, KY warehouse. If you need freight shipping, we will arrange commercial carrier transit and bill freight shipping rates separately to save you money.</p>
                </div>
            </div>

            <!-- Step 5 -->
            <div class="flex flex-col md:flex-row gap-8 items-center relative z-10">
                <div class="w-full md:w-1/2 flex justify-start md:justify-end md:pr-12">
                    <span class="bg-zinc-950 text-white font-black text-3xl sm:text-4xl h-16 w-16 sm:h-20 sm:w-20 rounded-full flex items-center justify-center shadow-lg border-4 border-white">05</span>
                </div>
                <div class="w-full md:w-1/2 bg-white border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm">
                    <span class="text-zinc-400 text-[10px] font-bold uppercase tracking-widest block mb-1">Step Five</span>
                    <h3 class="text-xl font-extrabold text-zinc-950 uppercase tracking-tight mb-3">Process, List, &amp; Profit</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">This is where the magic happens! Process your pallet. Sort items by category. List smaller products on eBay, Amazon, Poshmark, or Mercari. Sell bulk goods in your physical bin store or flea market stall. Resellers routinely multiply their initial wholesale pallet investment!</p>
                </div>
            </div>

        </div>
    </section>

    <!-- Warehouse CTA -->
    <section class="bg-zinc-950 text-white py-16 px-4 text-center">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-2xl sm:text-3xl font-extrabold uppercase tracking-tight mb-4">Want To Inspect Inventory In Person?</h2>
            <p class="text-zinc-400 text-sm sm:text-base leading-relaxed mb-8 max-w-xl mx-auto">Resellers and wholesale buyers are always welcome at our Louisville warehouse. Schedule a walkthrough, browse our aisles, and choose the exact pallets you want to buy.</p>
            <a href="{{ route('contact') }}" class="bg-white text-zinc-950 font-extrabold px-8 py-3.5 rounded text-sm uppercase tracking-wider hover:bg-zinc-200 transition duration-150 shadow">Schedule Warehouse Visit</a>
        </div>
    </section>
@endsection
