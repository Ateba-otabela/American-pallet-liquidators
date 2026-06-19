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
                <div x-data="{ isNew: {{ old('category_id') === 'new' ? 'true' : 'false' }} }">
                    <label for="category_id" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Category *</label>
                    <select id="category_id" name="category_id" x-on:change="isNew = $event.target.value === 'new'" required class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800 font-semibold">
                        <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Select Category...</option>
                        <option value="new" {{ old('category_id') === 'new' ? 'selected' : '' }} class="font-bold text-zinc-950 bg-gray-100">+ Create New Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror

                    <div x-show="isNew" x-cloak class="mt-3">
                        <label for="new_category_name" class="block text-[10px] font-black uppercase tracking-wider text-zinc-600 mb-1">New Category Name *</label>
                        <input type="text" id="new_category_name" name="new_category_name" value="{{ old('new_category_name') }}" placeholder="e.g. Health & Beauty" class="w-full bg-white border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:border-zinc-500 text-zinc-800" />
                        @error('new_category_name') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>
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
                <div class="sm:col-span-2">
                    <label for="images" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Product Images — Upload Multiple</label>
                    <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-zinc-500 transition cursor-pointer" onclick="document.getElementById('images').click()">
                        <svg class="h-8 w-8 text-zinc-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-xs font-bold text-zinc-500">Click to select images or drag & drop</p>
                        <p class="text-[10px] text-zinc-400 mt-1">PNG, JPG, WEBP — Max 5MB each — Multiple allowed</p>
                        <input type="file" id="images" name="images[]" accept="image/*" multiple class="hidden" onchange="previewImages(this)" />
                    </div>
                    <div id="image-preview" class="flex gap-3 mt-3 flex-wrap"></div>
                    @error('images.*') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
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

    <script>
        function previewImages(input) {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = '';
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const div = document.createElement('div');
                    div.className = 'relative h-20 w-20 rounded-lg overflow-hidden border-2 border-gray-200 flex-shrink-0';
                    div.innerHTML = `<img src="${e.target.result}" class="h-full w-full object-cover" />`;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
@endsection
