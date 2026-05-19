@extends('layouts.admin')

@section('admin_content')
    <div class="max-w-4xl bg-white border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm space-y-6">
        
        <div class="border-b border-gray-100 pb-4">
            <h2 class="text-lg font-black uppercase tracking-tight text-zinc-950">E-Commerce &amp; Payment Settings</h2>
            <p class="text-xs text-zinc-400 font-semibold mt-1">Configure credentials, support contacts, and offline payment instructions shown to buyers at checkout.</p>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-md font-bold text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8 text-sm">
            @csrf
            
            <!-- Section 1: Support Contact -->
            <div class="space-y-4">
                <h3 class="text-xs font-black uppercase tracking-widest text-zinc-900 border-b border-gray-100 pb-2">Support &amp; Contact Info</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="contact_email" class="block text-xs font-bold uppercase text-zinc-700 mb-1.5">Sales / Support Email</label>
                        <input type="email" id="contact_email" name="contact_email" value="{{ $settings['contact_email'] }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                    </div>
                    <div>
                        <label for="contact_phone" class="block text-xs font-bold uppercase text-zinc-700 mb-1.5">Logistics Support Phone</label>
                        <input type="text" id="contact_phone" name="contact_phone" value="{{ $settings['contact_phone'] }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                    </div>
                </div>
            </div>

            <!-- Section 2: Stripe Integration -->
            <div class="space-y-4">
                <h3 class="text-xs font-black uppercase tracking-widest text-zinc-900 border-b border-gray-100 pb-2">Stripe Payment Gateway</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="stripe_publishable_key" class="block text-xs font-bold uppercase text-zinc-700 mb-1.5">Stripe Publishable Key</label>
                        <input type="text" id="stripe_publishable_key" name="stripe_publishable_key" value="{{ $settings['stripe_publishable_key'] }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800 font-mono" />
                    </div>
                    <div>
                        <label for="stripe_secret_key" class="block text-xs font-bold uppercase text-zinc-700 mb-1.5">Stripe Secret Key</label>
                        <input type="password" id="stripe_secret_key" name="stripe_secret_key" value="{{ $settings['stripe_secret_key'] }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800 font-mono" />
                    </div>
                </div>
            </div>

            <!-- Section 3: Bank Wire Info -->
            <div class="space-y-4">
                <h3 class="text-xs font-black uppercase tracking-widest text-zinc-900 border-b border-gray-100 pb-2">Bank Wire Instructions (Chase Bank)</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="bank_name" class="block text-xs font-bold uppercase text-zinc-700 mb-1.5">Bank Name</label>
                        <input type="text" id="bank_name" name="bank_name" value="{{ $settings['bank_name'] }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                    </div>
                    <div>
                        <label for="bank_account_name" class="block text-xs font-bold uppercase text-zinc-700 mb-1.5">Account / Entity Name</label>
                        <input type="text" id="bank_account_name" name="bank_account_name" value="{{ $settings['bank_account_name'] }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="bank_routing_number" class="block text-xs font-bold uppercase text-zinc-700 mb-1.5">Routing Transit Number (ABA)</label>
                        <input type="text" id="bank_routing_number" name="bank_routing_number" value="{{ $settings['bank_routing_number'] }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800 font-bold" />
                    </div>
                    <div>
                        <label for="bank_account_number" class="block text-xs font-bold uppercase text-zinc-700 mb-1.5">Checking Account Number</label>
                        <input type="text" id="bank_account_number" name="bank_account_number" value="{{ $settings['bank_account_number'] }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800 font-bold" />
                    </div>
                </div>
            </div>

            <!-- Section 4: Mobile & Crypto Handles -->
            <div class="space-y-4">
                <h3 class="text-xs font-black uppercase tracking-widest text-zinc-900 border-b border-gray-100 pb-2">Zelle, Cash App, Crypto &amp; Mobile Handles</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="zelle_email" class="block text-xs font-bold uppercase text-zinc-700 mb-1.5">Zelle Registered Email/Phone</label>
                        <input type="text" id="zelle_email" name="zelle_email" value="{{ $settings['zelle_email'] }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                    </div>
                    <div>
                        <label for="cash_app_cashtag" class="block text-xs font-bold uppercase text-zinc-700 mb-1.5">Cash App $cashtag Handle</label>
                        <input type="text" id="cash_app_cashtag" name="cash_app_cashtag" value="{{ $settings['cash_app_cashtag'] }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800 font-bold text-zinc-950" />
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="venmo_handle" class="block text-xs font-bold uppercase text-zinc-700 mb-1.5">Venmo Business Profile Handle</label>
                        <input type="text" id="venmo_handle" name="venmo_handle" value="{{ $settings['venmo_handle'] }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                    </div>
                    <div>
                        <label for="paypal_email" class="block text-xs font-bold uppercase text-zinc-700 mb-1.5">PayPal Merchant Email</label>
                        <input type="email" id="paypal_email" name="paypal_email" value="{{ $settings['paypal_email'] }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                    </div>
                </div>
                <div>
                    <label for="USDT_address" class="block text-xs font-bold uppercase text-zinc-700 mb-1.5">Crypto USDT Wallet Deposit Address (TRC-20 / ERC-20)</label>
                    <input type="text" id="USDT_address" name="USDT_address" value="{{ $settings['USDT_address'] }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800 font-mono" />
                </div>
            </div>

            <button type="submit" class="w-full bg-zinc-950 text-white font-extrabold py-4 rounded text-xs uppercase tracking-widest hover:bg-zinc-800 transition duration-150 shadow-md">
                Save &amp; Apply All Settings
            </button>
        </form>

    </div>
@endsection
