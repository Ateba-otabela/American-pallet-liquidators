@extends('layouts.ecommerce')

@section('title', 'Frequently Asked Questions — APL Pallets')

@section('content')
    <!-- Header -->
    <section class="bg-white border-b border-gray-200 py-16 text-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-zinc-500 text-xs font-extrabold uppercase tracking-widest block mb-2">Merchant Resource Center</span>
            <h1 class="text-3xl sm:text-5xl font-black text-zinc-950 uppercase tracking-tight mb-4">Frequently Asked Questions</h1>
            <p class="text-slate-500 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">Everything you need to know about purchasing wholesale liquidation pallets, retail store truckloads, and freight logistics.</p>
        </div>
    </section>

    <!-- FAQs Accordion List -->
    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-20" x-data="{ active: null }">
        <div class="space-y-4">
            
            <!-- Q1 -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <button @click="active = (active === 1 ? null : 1)" class="w-full text-left p-6 flex justify-between items-center focus:outline-none">
                    <span class="font-extrabold text-zinc-950 uppercase tracking-tight text-sm sm:text-base">What is liquidated merchandise?</span>
                    <svg class="h-5 w-5 text-zinc-400 transform transition-transform duration-200" :class="active === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="active === 1" x-collapse class="border-t border-gray-100 p-6 text-sm text-slate-500 leading-relaxed" x-cloak>
                    Liquidated merchandise consists of products returned by consumers, overstocks, shelf pulls, abandoned warehouse freight, and closeout inventories. Retail giants and online fulfillment centers liquidate these goods in massive volumes to clear shelf space immediately, which allows us to purchase them at deep wholesale discounts and pass those savings to you.
                </div>
            </div>

            <!-- Q2 -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <button @click="active = (active === 2 ? null : 2)" class="w-full text-left p-6 flex justify-between items-center focus:outline-none">
                    <span class="font-extrabold text-zinc-950 uppercase tracking-tight text-sm sm:text-base">Why are the prices so cheap?</span>
                    <svg class="h-5 w-5 text-zinc-400 transform transition-transform duration-200" :class="active === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="active === 2" x-collapse class="border-t border-gray-100 p-6 text-sm text-slate-500 leading-relaxed" x-cloak>
                    Our prices are a tiny fraction of the original retail value because we hold direct supplier contracts with retail corporations and buy in colossal, multi-truckload volumes. Because there are no middlemen, brokers, or markup agents in our chain, we sell directly to resellers at our raw warehouse contract rates.
                </div>
            </div>

            <!-- Q3 -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <button @click="active = (active === 3 ? null : 3)" class="w-full text-left p-6 flex justify-between items-center focus:outline-none">
                    <span class="font-extrabold text-zinc-950 uppercase tracking-tight text-sm sm:text-base">Where is your warehouse located? Can I pick up?</span>
                    <svg class="h-5 w-5 text-zinc-400 transform transition-transform duration-200" :class="active === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="active === 3" x-collapse class="border-t border-gray-100 p-6 text-sm text-slate-500 leading-relaxed" x-cloak>
                    Our main liquidation warehouse is located in Louisville, Kentucky. Wholesale merchants and local resellers are welcome to inspect inventory and pick up their purchases in person! Forklift dock loading is always provided free of charge at our warehouse. Select "Cash on Pickup" at checkout or pay online, then contact us to schedule your loading dock reservation.
                </div>
            </div>

            <!-- Q4 -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <button @click="active = (active === 4 ? null : 4)" class="w-full text-left p-6 flex justify-between items-center focus:outline-none">
                    <span class="font-extrabold text-zinc-950 uppercase tracking-tight text-sm sm:text-base">Do you offer freight shipping? How is shipping calculated?</span>
                    <svg class="h-5 w-5 text-zinc-400 transform transition-transform duration-200" :class="active === 4 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="active === 4" x-collapse class="border-t border-gray-100 p-6 text-sm text-slate-500 leading-relaxed" x-cloak>
                    Yes, we ship nationwide! We work directly with major LTL and commercial truckload freight carriers to find the lowest shipping rates available. Shipping fees are not billed at the initial online checkout. Instead, freight shipping logistics and costs are calculated and billed separately after order placement based on the delivery zip code and pallet counts.
                </div>
            </div>

            <!-- Q5 -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <button @click="active = (active === 5 ? null : 5)" class="w-full text-left p-6 flex justify-between items-center focus:outline-none">
                    <span class="font-extrabold text-zinc-950 uppercase tracking-tight text-sm sm:text-base">What are the available payment methods?</span>
                    <svg class="h-5 w-5 text-zinc-400 transform transition-transform duration-200" :class="active === 5 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="active === 5" x-collapse class="border-t border-gray-100 p-6 text-sm text-slate-500 leading-relaxed" x-cloak>
                    We support 8 payment methods to serve merchants of all scales. You can complete secure debit or credit card checkout using our integrated Stripe Elements. We also accept offline options: Chase Bank Wire Transfer, Zelle Business, Cash App, Venmo, PayPal, USDT crypto (TRC-20 / ERC-20), or Cash on Pickup at our warehouse facility. Complete payment details are shown on the checkout payment page and in your order email.
                </div>
            </div>

            <!-- Q6 -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <button @click="active = (active === 6 ? null : 6)" class="w-full text-left p-6 flex justify-between items-center focus:outline-none">
                    <span class="font-extrabold text-zinc-950 uppercase tracking-tight text-sm sm:text-base">Can I return a pallet if I am not satisfied?</span>
                    <svg class="h-5 w-5 text-zinc-400 transform transition-transform duration-200" :class="active === 6 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="active === 6" x-collapse class="border-t border-gray-100 p-6 text-sm text-slate-500 leading-relaxed" x-cloak>
                    No, all sales are strictly final. Liquidation merchandise is sold strictly <strong>AS-IS / WHERE-IS</strong>, with no warranties, returns, refunds, or exchanges. Consumer return loads can contain a mixture of brand new, open box, damaged, or incomplete items. We encourage buyers to visit our warehouse in person to inspect available stock.
                </div>
            </div>

            <!-- Q7 -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <button @click="active = (active === 7 ? null : 7)" class="w-full text-left p-6 flex justify-between items-center focus:outline-none">
                    <span class="font-extrabold text-zinc-950 uppercase tracking-tight text-sm sm:text-base">What are raw customer returns vs shelf pulls?</span>
                    <svg class="h-5 w-5 text-zinc-400 transform transition-transform duration-200" :class="active === 7 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="active === 7" x-collapse class="border-t border-gray-100 p-6 text-sm text-slate-500 leading-relaxed" x-cloak>
                    <strong>Shelf pulls</strong> are brand new, overstock retail goods that were removed from shelves to make room for new inventory. They usually have price tags and are in perfect retail condition. <strong>Raw customer returns</strong> are items purchased by retail customers and returned for various reasons. Some customer returns are completely brand new and unopened, while others may be opened, used, missing parts, or damaged.
                </div>
            </div>

        </div>
    </section>
@endsection
