@extends('layouts.admin')

@section('admin_content')
    <div class="max-w-2xl bg-white border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm space-y-6">
        
        <div class="border-b border-gray-100 pb-4 flex justify-between items-center">
            <h2 class="text-lg font-black uppercase tracking-tight text-zinc-950">Add Liquidation Lot</h2>
            <a href="{{ route('admin.products') }}" class="text-xs font-bold text-zinc-500 hover:text-zinc-950">&larr; Back to inventory</a>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Lot Name / Title *</label>
                    <input type="text" id="name" name="name" required value="{{ old('name') }}" placeholder="Target General Merchandise Truckload" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                    @error('name') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="category_id" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Category *</label>
                    <select id="category_id" name="category_id" required class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800 font-semibold">
                        <option value="" disabled selected>Select Category...</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="price" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Sale Price ($) *</label>
                    <input type="number" id="price" name="price" step="0.01" required value="{{ old('price') }}" placeholder="699.00" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800 font-bold" />
                    @error('price') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="original_price" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Original / Strikethrough ($)</label>
                    <input type="number" id="original_price" name="original_price" step="0.01" value="{{ old('original_price') }}" placeholder="899.00" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                    @error('original_price') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="stock" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Stock Count *</label>
                    <input type="number" id="stock" name="stock" required value="{{ old('stock', 1) }}" placeholder="5" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800 font-bold" />
                    @error('stock') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="badge" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Badge Indicator</label>
                    <select id="badge" name="badge" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800 font-semibold">
                        <option value="">No Badge (Standard)</option>
                        <option value="sale" {{ old('badge') == 'sale' ? 'selected' : '' }}>On Sale</option>
                        <option value="sold_out" {{ old('badge') == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                    </select>
                    @error('badge') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="image" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Product Image (Upload)</label>
                    <input type="file" id="image" name="image" accept="image/*" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                    @error('image') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Lot Description &amp; Specifications *</label>
                <textarea id="description" name="description" rows="6" required placeholder="Describe piece count, specific retailer brands included, condition details..." class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800 leading-relaxed">{{ old('description') }}</textarea>
                @error('description') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-zinc-950 text-white font-extrabold py-3.5 rounded text-xs uppercase tracking-widest hover:bg-zinc-800 transition duration-150 shadow-md">
                Create E-Commerce Product
            </button>
        </form>

    </div>
@endsection
