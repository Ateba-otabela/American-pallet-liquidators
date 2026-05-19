@extends('layouts.admin')

@section('admin_content')
    <div class="max-w-2xl bg-white border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm space-y-6">
        
        <div class="border-b border-gray-100 pb-4 flex justify-between items-center">
            <h2 class="text-lg font-black uppercase tracking-tight text-zinc-950">Edit Liquidation Lot</h2>
            <a href="{{ route('admin.products') }}" class="text-xs font-bold text-zinc-500 hover:text-zinc-950">&larr; Back to inventory</a>
        </div>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Lot Name / Title *</label>
                    <input type="text" id="name" name="name" required value="{{ old('name', $product->name) }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                    @error('name') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="category_id" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Category *</label>
                    <select id="category_id" name="category_id" required class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800 font-semibold">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="price" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Sale Price ($) *</label>
                    <input type="number" id="price" name="price" step="0.01" required value="{{ old('price', $product->price) }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800 font-bold" />
                    @error('price') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="original_price" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Original / Strikethrough ($)</label>
                    <input type="number" id="original_price" name="original_price" step="0.01" value="{{ old('original_price', $product->original_price) }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                    @error('original_price') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="stock" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Stock Count *</label>
                    <input type="number" id="stock" name="stock" required value="{{ old('stock', $product->stock) }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800 font-bold" />
                    @error('stock') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="badge" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Badge Indicator</label>
                    <select id="badge" name="badge" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800 font-semibold">
                        <option value="">No Badge (Standard)</option>
                        <option value="sale" {{ old('badge', $product->badge) == 'sale' ? 'selected' : '' }}>On Sale</option>
                        <option value="sold_out" {{ old('badge', $product->badge) == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                    </select>
                    @error('badge') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="image" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Product Image (Upload New)</label>
                    <input type="file" id="image" name="image" accept="image/*" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800 mb-2" />
                    @if(isset($product->images[0]))
                        <div class="flex items-center gap-2">
                            <img src="{{ $product->images[0] }}" class="h-10 w-10 object-cover rounded border border-gray-200" alt="Current image">
                            <span class="text-xs text-zinc-500 font-bold">Current Image</span>
                        </div>
                    @endif
                    @error('image') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Lot Description &amp; Specifications *</label>
                <textarea id="description" name="description" rows="6" required class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800 leading-relaxed">{{ old('description', $product->description) }}</textarea>
                @error('description') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-zinc-950 text-white font-extrabold py-3.5 rounded text-xs uppercase tracking-widest hover:bg-zinc-800 transition duration-150 shadow-md">
                Update Catalog Lot details
            </button>
        </form>

    </div>
@endsection
