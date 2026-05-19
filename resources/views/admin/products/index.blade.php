@extends('layouts.admin')

@section('admin_content')
    <div class="space-y-6">
        
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-extrabold text-zinc-950 uppercase tracking-tight">Active Inventory Lots</h2>
            <a href="{{ route('admin.products.create') }}" class="bg-zinc-950 text-white font-extrabold px-5 py-2.5 rounded text-xs uppercase tracking-widest hover:bg-zinc-800 transition duration-150 shadow-sm">
                Create New Lot
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-md font-bold text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-[10px] font-black uppercase tracking-wider text-zinc-400 border-b border-gray-100">
                            <th class="p-4">Image</th>
                            <th class="p-4">Product Name</th>
                            <th class="p-4">Category</th>
                            <th class="p-4">Badge</th>
                            <th class="p-4">Stock</th>
                            <th class="p-4">Price</th>
                            <th class="p-4">Original Price</th>
                            <th class="p-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 font-semibold">
                        @foreach($products as $product)
                            <tr>
                                <td class="p-4">
                                    <div class="h-10 w-10 bg-gray-50 border border-gray-100 rounded overflow-hidden flex items-center justify-center">
                                        <img src="{{ $product->first_image_url }}" alt="{{ $product->name }}" class="object-cover max-h-full max-w-full" />
                                    </div>
                                </td>
                                <td class="p-4 text-zinc-950 font-bold uppercase tracking-tight">{{ $product->name }}</td>
                                <td class="p-4 text-zinc-500">{{ $product->category->name }}</td>
                                <td class="p-4">
                                    @if($product->badge)
                                        <span class="text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded
                                            {{ $product->badge === 'sold_out' ? 'bg-zinc-950 text-white' : '' }}
                                            {{ $product->badge === 'sale' ? 'bg-red-50 text-red-600' : '' }}
                                        ">
                                            {{ str_replace('_', ' ', $product->badge) }}
                                        </span>
                                    @else
                                        <span class="text-zinc-300 italic font-medium">None</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <span class="{{ $product->stock <= 3 ? 'text-amber-600 font-extrabold' : 'text-zinc-600' }}">
                                        {{ $product->stock }} unit(s)
                                    </span>
                                </td>
                                <td class="p-4 text-zinc-950 font-extrabold">${{ number_format($product->price, 2) }}</td>
                                <td class="p-4 text-zinc-400">
                                    @if($product->original_price)
                                        ${{ number_format($product->original_price, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="p-4 flex items-center gap-3">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-zinc-950 hover:underline">Edit</a>
                                    
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you absolutely sure you want to delete this liquidated lot from the active catalog?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>

    </div>
@endsection
