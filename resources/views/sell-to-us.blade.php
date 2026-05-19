@extends('layouts.ecommerce')

@section('title', 'Sell Your Excess Inventory & Closeouts To Us')

@section('content')
    <!-- Header -->
    <section class="bg-white border-b border-gray-200 py-16 text-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-zinc-500 text-xs font-extrabold uppercase tracking-widest block mb-2">Partner With Us</span>
            <h1 class="text-3xl sm:text-5xl font-black text-zinc-950 uppercase tracking-tight mb-4">Sell Us Your Excess Inventory</h1>
            <p class="text-slate-500 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">Turn your liability into liquidity. We buy closeouts, warehouse overstocks, shelf pulls, customer returns, abandoned freight, and liquidations for cash.</p>
        </div>
    </section>

    <!-- 3 Steps process -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-16">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-zinc-950 uppercase tracking-tight">Our 3-Step Purchase Process</h2>
            <p class="text-slate-500 text-sm max-w-md mx-auto mt-2">We make it quick and painless to offload large volumes of product immediately.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="bg-white border border-gray-200 rounded-lg p-8 shadow-sm flex flex-col justify-between">
                <div>
                    <span class="text-zinc-300 font-black text-6xl leading-none block mb-4">01</span>
                    <h3 class="text-lg font-extrabold text-zinc-950 uppercase tracking-tight mb-3">Submit Offer Details</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Send us details about your excess stock, manifest lists, quantity counts, product categories, and representative photos. The more information you provide, the faster we can review.</p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="bg-white border border-gray-200 rounded-lg p-8 shadow-sm flex flex-col justify-between">
                <div>
                    <span class="text-zinc-300 font-black text-6xl leading-none block mb-4">02</span>
                    <h3 class="text-lg font-extrabold text-zinc-950 uppercase tracking-tight mb-3">Get Cash Offer</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Our experienced purchasing team analyzes your inventory manifest and issues a competitive cash purchase proposal within 24 to 48 hours. We buy entire lots, no cherry-picking!</p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="bg-white border border-gray-200 rounded-lg p-8 shadow-sm flex flex-col justify-between">
                <div>
                    <span class="text-zinc-300 font-black text-6xl leading-none block mb-4">03</span>
                    <h3 class="text-lg font-extrabold text-zinc-950 uppercase tracking-tight mb-3">Fast Pickup &amp; Pay</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Once the cash proposal is agreed, we arrange immediate bank wire payment and coordinate all logistics, LTL trucking, or full truckload pickups from your facility immediately.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Kinds of Inventory We Buy -->
    <section class="bg-zinc-950 text-white py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <h2 class="text-2xl sm:text-3xl font-extrabold uppercase tracking-tight">Merchandise We Buy</h2>
                <p class="text-zinc-400 text-sm mt-2">We acquire substantial quantities across a vast array of consumer and industrial categories.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto text-center font-bold uppercase tracking-wider text-xs">
                <div class="bg-zinc-900 border border-zinc-800 p-6 rounded hover:bg-zinc-800 transition">Apparel &amp; Footwear</div>
                <div class="bg-zinc-900 border border-zinc-800 p-6 rounded hover:bg-zinc-800 transition">Electronics &amp; Gadgets</div>
                <div class="bg-zinc-900 border border-zinc-800 p-6 rounded hover:bg-zinc-800 transition">Housewares &amp; Kitchen</div>
                <div class="bg-zinc-900 border border-zinc-800 p-6 rounded hover:bg-zinc-800 transition">Health &amp; Beauty (HBA)</div>
                <div class="bg-zinc-900 border border-zinc-800 p-6 rounded hover:bg-zinc-800 transition">Tools &amp; Hardware</div>
                <div class="bg-zinc-900 border border-zinc-800 p-6 rounded hover:bg-zinc-800 transition">Toys &amp; Baby Goods</div>
                <div class="bg-zinc-900 border border-zinc-800 p-6 rounded hover:bg-zinc-800 transition">Bedding &amp; Home Textiles</div>
                <div class="bg-zinc-900 border border-zinc-800 p-6 rounded hover:bg-zinc-800 transition">General Merchandise</div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('contact') }}" class="bg-white text-zinc-950 font-extrabold px-8 py-3.5 rounded text-sm uppercase tracking-wider hover:bg-zinc-200 transition shadow inline-block">Contact Purchasing Team</a>
            </div>
        </div>
    </section>
@endsection
