@extends('layouts.admin')

@section('admin_content')
    <div class="space-y-6">
        
        <h2 class="text-xl font-extrabold text-zinc-950 uppercase tracking-tight">Customer Sales Orders</h2>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-md font-bold text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-md font-bold text-sm mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-[10px] font-black uppercase tracking-wider text-zinc-400 border-b border-gray-100">
                            <th class="p-4">Order Number</th>
                            <th class="p-4">Customer Details</th>
                            <th class="p-4">Payment Method</th>
                            <th class="p-4">Total</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Date Placed</th>
                            <th class="p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 font-semibold">
                        @foreach($orders as $order)
                            <tr>
                                <td class="p-4 text-zinc-900 font-bold">{{ $order->order_number }}</td>
                                <td class="p-4">
                                    <span class="block text-zinc-950">{{ $order->receiver_info['name'] }}</span>
                                    <span class="block text-zinc-400 text-[10px]">{{ $order->receiver_info['email'] }}</span>
                                </td>
                                <td class="p-4 uppercase text-[10px] text-zinc-500">{{ str_replace('_', ' ', $order->payment_method) }}</td>
                                <td class="p-4 font-black text-zinc-950">${{ number_format($order->total, 2) }}</td>
                                <td class="p-4">
                                    <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="flex items-center gap-1">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" class="text-[9px] font-black uppercase tracking-wider px-2 py-1 rounded border-none cursor-pointer focus:ring-0
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
                                <td class="p-4 text-zinc-500">{{ $order->created_at->format('M d, Y H:i') }}</td>
                                <td class="p-4">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-zinc-950 hover:underline">Manage Order</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>

    </div>
@endsection
