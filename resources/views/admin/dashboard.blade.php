@extends('layouts.admin')

@section('admin_content')
    <div class="space-y-8">
        
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-md font-bold text-sm">
                {{ session('error') }}
            </div>
        @endif
        
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-md font-bold text-sm">
                {{ session('success') }}
            </div>
        @endif
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Revenue -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <span class="block text-xs font-black uppercase tracking-wider text-zinc-400 mb-2">Total Sales Revenue</span>
                <span class="block text-2xl font-black text-zinc-950">${{ number_format($totalSales, 2) }}</span>
            </div>

            <!-- Orders Count -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <span class="block text-xs font-black uppercase tracking-wider text-zinc-400 mb-2">Total Orders Placed</span>
                <span class="block text-2xl font-black text-zinc-950">{{ $ordersCount }}</span>
            </div>

            <!-- Products Count -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <span class="block text-xs font-black uppercase tracking-wider text-zinc-400 mb-2">Active Catalog Lots</span>
                <span class="block text-2xl font-black text-zinc-950">{{ $productsCount }}</span>
            </div>

            <!-- Low Stock Warnings -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <span class="block text-xs font-black uppercase tracking-wider text-zinc-400 mb-2">Low Stock Alerts</span>
                <span class="block text-2xl font-black {{ $lowStockProducts->count() > 0 ? 'text-amber-600' : 'text-emerald-600' }}">
                    {{ $lowStockProducts->count() }} Lot(s)
                </span>
            </div>
        </div>

        <!-- Main section grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left: Recent Orders -->
            <div class="lg:col-span-2 bg-white border border-gray-200 rounded-lg p-6 shadow-sm space-y-6">
                <h3 class="text-sm font-black uppercase tracking-wider text-zinc-900 border-b border-gray-100 pb-3">Recent E-Commerce Sales</h3>
                
                @if($recentOrders->count() === 0)
                    <div class="p-8 text-center text-zinc-400 text-sm">No sales orders received yet.</div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs sm:text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-[10px] font-black uppercase tracking-wider text-zinc-400 border-b border-gray-100">
                                    <th class="p-3">Order Number</th>
                                    <th class="p-3">Customer Info</th>
                                    <th class="p-3">Payment</th>
                                    <th class="p-3">Total</th>
                                    <th class="p-3">Status</th>
                                    <th class="p-3">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 font-semibold">
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td class="p-3 text-zinc-900 font-bold">{{ $order->order_number }}</td>
                                        <td class="p-3">
                                            <span class="block text-zinc-900">{{ $order->receiver_info['name'] }}</span>
                                            <span class="block text-slate-400 text-[10px] font-medium">{{ $order->receiver_info['email'] }}</span>
                                        </td>
                                        <td class="p-3 uppercase text-[10px] text-zinc-500">{{ str_replace('_', ' ', $order->payment_method) }}</td>
                                        <td class="p-3 font-extrabold text-zinc-950">${{ number_format($order->total, 2) }}</td>
                                        <td class="p-3">
                                            <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="flex items-center gap-1">
                                                @csrf
                                                <select name="status" onchange="this.form.submit()" class="text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded border-none cursor-pointer focus:ring-0
                                                    {{ $order->status === 'delivered' ? 'bg-emerald-50 text-emerald-600' : '' }}
                                                    {{ $order->status === 'processing' || $order->status === 'shipped' ? 'bg-blue-50 text-blue-600' : '' }}
                                                    {{ $order->status === 'pending_payment' ? 'bg-amber-50 text-amber-600' : '' }}
                                                    {{ $order->status === 'cancelled' ? 'bg-red-50 text-red-600' : '' }}
                                                ">
                                                    <option value="pending_payment" {{ $order->status === 'pending_payment' ? 'selected' : '' }}>Pending Payment</option>
                                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="p-3">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="text-zinc-950 hover:underline">Manage</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Right: Low Stock Alert Sidebar -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm space-y-6">
                <h3 class="text-sm font-black uppercase tracking-wider text-zinc-900 border-b border-gray-100 pb-3">Restock Alerts</h3>
                
                @if($lowStockProducts->count() === 0)
                    <div class="p-8 text-center text-emerald-600 text-xs font-bold uppercase tracking-wider">All lots fully stocked</div>
                @else
                    <ul class="divide-y divide-gray-100">
                        @foreach($lowStockProducts as $low)
                            <li class="py-3 flex justify-between items-center text-xs">
                                <div>
                                    <span class="block font-bold text-zinc-900 uppercase leading-snug truncate max-w-[150px]" title="{{ $low->name }}">{{ $low->name }}</span>
                                    <span class="block text-zinc-400 text-[10px]">{{ $low->category->name }}</span>
                                </div>
                                <span class="font-black text-amber-600 uppercase tracking-widest bg-amber-50 px-2 py-1 rounded">
                                    {{ $low->stock }} left
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>

    </div>
@endsection
