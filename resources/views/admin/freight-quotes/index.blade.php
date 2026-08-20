@extends('layouts.app')

@section('title', 'Freight Quotes — Admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Freight Quote Requests</h1>
                </div>

                @if($quotes->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destination</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delivery</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($quotes as $quote)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $quote->customer_name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $quote->email }}</div>
                                            <div class="text-sm text-gray-500">{{ $quote->phone }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($quote->product)
                                                <div class="text-sm text-gray-900">{{ $quote->product->name }}</div>
                                                <div class="text-sm text-gray-500">Qty: {{ $quote->quantity }}</div>
                                            @else
                                                <div class="text-sm text-gray-500">General/Multiple</div>
                                                <div class="text-sm text-gray-500">Qty: {{ $quote->quantity }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $quote->destination_zip }}</div>
                                            @if($quote->has_loading_dock)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    Has Loading Dock
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ ucfirst($quote->delivery_type) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('admin.freight-quotes.status', $quote) }}" method="POST" class="inline">
                                                @csrf
                                                <select name="status" onchange="this.form.submit()" class="text-sm rounded border-gray-300 @if($quote->status === 'pending') bg-yellow-100 text-yellow-800 @elseif($quote->status === 'replied') bg-blue-100 text-blue-800 @elseif($quote->status === 'completed') bg-green-100 text-green-800 @else bg-gray-100 text-gray-800 @endif">
                                                    <option value="pending" {{ $quote->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="replied" {{ $quote->status === 'replied' ? 'selected' : '' }}>Replied</option>
                                                    <option value="completed" {{ $quote->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="cancelled" {{ $quote->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $quote->created_at->format('M j, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <form action="{{ route('admin.freight-quotes.destroy', $quote) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this freight quote?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    
                                    @if($quote->notes)
                                        <tr class="bg-gray-50">
                                            <td colspan="8" class="px-6 py-3">
                                                <div class="text-sm text-gray-600">
                                                    <span class="font-semibold">Notes:</span> {{ $quote->notes }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $quotes->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No freight quotes</h3>
                        <p class="mt-1 text-sm text-gray-500">No freight quote requests have been submitted yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
