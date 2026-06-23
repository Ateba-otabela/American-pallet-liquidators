@extends('layouts.ecommerce')

@section('title', 'Contact American Pallet Liquidators')

@section('content')
    <!-- Header -->
    <section class="bg-white border-b border-gray-200 py-16 text-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-zinc-500 text-xs font-extrabold uppercase tracking-widest block mb-2">Merchant Center</span>
            <h1 class="text-3xl sm:text-5xl font-black text-zinc-950 uppercase tracking-tight mb-4">Contact Our Warehouse</h1>
            <p class="text-slate-500 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">Reach out to purchase liquidation pallets, schedule warehouse cargo pickups, or request a freight shipping quote.</p>
        </div>
    </section>

    <!-- Content Grid -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            
            <!-- Left Column: Contact details & Map -->
            <div class="space-y-8 bg-white border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm">
                <div>
                    <h2 class="text-xl font-extrabold text-zinc-950 uppercase tracking-tight mb-4">Warehouse Contact Details</h2>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-4">
                            <span class="bg-zinc-100 text-zinc-900 p-2.5 rounded shadow-sm">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </span>
                            <div>
                                <span class="block text-xs font-black uppercase tracking-wider text-zinc-400">Phone Call / SMS Support</span>
                                <a href="tel:+447882769759" class="text-zinc-950 font-extrabold text-lg sm:text-xl hover:underline">+44 7882 769759</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="bg-zinc-100 text-zinc-900 p-2.5 rounded shadow-sm flex-shrink-0">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </span>
                            <div class="min-w-0">
                                <span class="block text-xs font-black uppercase tracking-wider text-zinc-400">General &amp; Sales Email</span>
                                <a href="mailto:americanpalletliquidators0@gmail.com" class="text-zinc-950 font-extrabold text-lg sm:text-xl hover:underline break-all">americanpalletliquidators0@gmail.com</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="bg-zinc-100 text-zinc-900 p-2.5 rounded shadow-sm">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </span>
                            <div>
                                <span class="block text-xs font-black uppercase tracking-wider text-zinc-400">Louisville Warehouse Facility</span>
                                <address class="not-italic text-zinc-950 font-extrabold text-lg leading-snug">
                                    American Pallet Liquidators<br>Louisville, KY
                                </address>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="bg-zinc-100 text-zinc-900 p-2.5 rounded shadow-sm">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm6 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.5 10a6.5 6.5 0 00-6.5 6.5v1h13v-1A6.5 6.5 0 0011.5 10zm5 0h1.5a2 2 0 012 2v1h-4m-10 0H3.5a2 2 0 00-2 2v1h4"/></svg>
                            </span>
                            <div>
                                <span class="block text-xs font-black uppercase tracking-wider text-zinc-400">Business Registration</span>
                                <p class="text-zinc-950 font-extrabold text-lg leading-snug">
                                    American Pallet Liquidators LLC<br>
                                    Kentucky Secretary of State ID: 0637756<br>
                                    Wholesale Distributor / Resale License
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Open Hours -->
                <div class="pt-6 border-t border-gray-100">
                    <span class="block text-xs font-black uppercase tracking-wider text-zinc-400 mb-2">Hours of Operation</span>
                    <p class="text-sm font-semibold text-zinc-800">Monday - Friday: 9:00 AM - 5:00 PM EST</p>
                    <p class="text-sm text-slate-500">Saturday &amp; Sunday: Closed (Loading dock pickup by pre-approved appointment only)</p>
                </div>

                <!-- Google Maps -->
                <div class="aspect-[16/9] w-full bg-gray-100 border border-gray-200 rounded overflow-hidden relative shadow-inner">
                    <iframe 
                        class="absolute inset-0 w-full h-full"
                        style="border:0;" 
                        loading="lazy" 
                        allowfullscreen 
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://maps.google.com/maps?q=Louisville,%20KY&t=&z=11&ie=UTF8&iwloc=&output=embed">
                    </iframe>
                </div>
            </div>

            <!-- Right Column: Contact form -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm">
                <h2 class="text-xl font-extrabold text-zinc-950 uppercase tracking-tight mb-4">Send Us A Message</h2>
                <p class="text-slate-500 text-sm mb-6">Have questions or want to purchase? Fill in the form below and our wholesale representatives will reach out immediately.</p>

                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-md font-bold mb-6 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <script>
                    function sendToWhatsapp(event) {
                        event.preventDefault();
                        const name = document.getElementById('name').value;
                        const email = document.getElementById('email').value;
                        const phone = document.getElementById('phone').value;
                        const message = document.getElementById('message').value;

                        const whatsappMessage = encodeURIComponent(`Name: ${name}\nEmail: ${email}\nPhone: ${phone}\nMessage: ${message}`);
                        const whatsappUrl = `https://wa.me/447882769759?text=${whatsappMessage}`;
                        
                        window.open(whatsappUrl, '_blank');
                    }
                </script>

                <form onsubmit="sendToWhatsapp(event)" class="space-y-4">
                    <div>
                        <label for="name" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Full Name</label>
                        <input type="text" id="name" name="name" required class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Email Address</label>
                            <input type="email" id="email" name="email" required class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                        </div>
                        <div>
                            <label for="phone" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Phone Number</label>
                            <input type="text" id="phone" name="phone" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                        </div>
                    </div>

                    <div>
                        <label for="message" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Your Message / Inquiry</label>
                        <textarea id="message" name="message" rows="5" required placeholder="Describe the pallets or truckloads you are interested in..." class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-zinc-950 text-white font-extrabold py-3.5 rounded text-xs uppercase tracking-widest hover:bg-zinc-800 transition duration-150 shadow-md">
                        Submit Inquiry via WhatsApp
                    </button>
                </form>
            </div>

        </div>
    </section>

    <!-- Reviews, Testimonials and Refund Policy -->
    <section class="bg-zinc-950 text-white py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid gap-6 lg:grid-cols-3 mb-12">
                <div class="bg-zinc-900 rounded-3xl p-8 shadow-xl border border-zinc-800">
                    <span class="text-xs font-bold uppercase tracking-widest text-amber-300">Customer Reviews</span>
                    <h2 class="mt-4 text-2xl font-extrabold uppercase tracking-tight">What buyers say</h2>
                    <p class="mt-4 text-sm leading-relaxed text-zinc-300">Verified wholesale customers consistently praise our pricing, accuracy, and timely pallet fulfillment across every shipment.</p>
                </div>
                <div class="bg-white rounded-3xl p-8 shadow-xl">
                    <p class="text-xs font-bold uppercase tracking-widest text-zinc-500">Rating</p>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="text-2xl font-black text-zinc-950">4.9</span>
                        <span class="text-sm uppercase tracking-widest text-zinc-500">out of 5</span>
                    </div>
                    <div class="mt-4 space-y-2 text-sm text-zinc-600">
                        <p><strong>95% of buyers</strong> reported repeat pallet orders within 90 days.</p>
                        <p><strong>92% of customers</strong> said inventory descriptions matched delivered stock.</p>
                    </div>
                </div>
                <div class="bg-zinc-900 rounded-3xl p-8 shadow-xl border border-zinc-800">
                    <p class="text-xs font-bold uppercase tracking-widest text-cyan-300">Refund Policy</p>
                    <h3 class="mt-4 text-xl font-extrabold text-white uppercase tracking-tight">Final Sale Liquidations</h3>
                    <p class="mt-4 text-sm leading-relaxed text-zinc-300">All liquidation merchandise is sold strictly <strong>AS-IS / WHERE-IS</strong>. There are no refunds, returns, or exchanges on pallet or truckload purchases.</p>
                    <p class="mt-4 text-sm leading-relaxed text-zinc-300">Please review our <a href="{{ route('faq') }}" class="text-white underline">FAQ</a> for full terms and freight pickup policies.</p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-200 mb-8">
                <p class="text-xs font-bold uppercase tracking-widest text-cyan-500">Refund Policy</p>
                <h3 class="mt-4 text-2xl font-extrabold text-zinc-950 uppercase tracking-tight">Liquidation pallet orders are final sale</h3>
                <ul class="mt-4 space-y-3 text-sm text-zinc-700 leading-relaxed">
                    <li>• All pallets and truckloads are sold <strong>as-is, where-is</strong>.</li>
                    <li>• No refunds, returns, or exchanges on liquidation stock.</li>
                    <li>• Inspect all shipment details before purchase and verify freight terms.</li>
                    <li>• Questions? Contact us directly or consult our <a href="{{ route('faq') }}" class="underline text-zinc-950">FAQ page</a>.</li>
                </ul>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <article class="bg-white rounded-3xl p-6 shadow-xl border border-gray-200">
                    <div class="flex items-center gap-4 mb-6">
                        <img src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?auto=format&fit=crop&w=400&q=80" alt="Alisha Reed" class="h-14 w-14 rounded-full object-cover">
                        <div>
                            <p class="font-bold uppercase text-zinc-950 text-sm tracking-widest">Alisha Reed</p>
                            <p class="text-xs uppercase tracking-widest text-zinc-500">Retail Resale Owner</p>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-zinc-700">“Reliable pallet arrivals, honest descriptions, and excellent support. I now source 80% of my resale inventory through APL and have more confidence in every purchase.”</p>
                </article>
                <article class="bg-white rounded-3xl p-6 shadow-xl border border-gray-200">
                    <div class="flex items-center gap-4 mb-6">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80" alt="Marcus Lee" class="h-14 w-14 rounded-full object-cover">
                        <div>
                            <p class="font-bold uppercase text-zinc-950 text-sm tracking-widest">Marcus Lee</p>
                            <p class="text-xs uppercase tracking-widest text-zinc-500">Market Stall Merchant</p>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-zinc-700">“This team delivers fast, and the pallets always match expectations. Their pricing is competitive and the pickup process is straightforward.”</p>
                </article>
                <article class="bg-white rounded-3xl p-6 shadow-xl border border-gray-200">
                    <div class="flex items-center gap-4 mb-6">
                        <img src="https://images.unsplash.com/photo-1544723795-3fb6469f5b39?auto=format&fit=crop&w=400&q=80" alt="Nina Carter" class="h-14 w-14 rounded-full object-cover">
                        <div>
                            <p class="font-bold uppercase text-zinc-950 text-sm tracking-widest">Nina Carter</p>
                            <p class="text-xs uppercase tracking-widest text-zinc-500">Online Resale Store</p>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-zinc-700">“Their liquidation truckloads helped me scale my business quickly. The checkout instructions are clear and the freight support is very helpful.”</p>
                </article>
            </div>
        </div>
    </section>
@endsection
