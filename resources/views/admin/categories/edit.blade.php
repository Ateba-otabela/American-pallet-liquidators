@extends('layouts.admin')

@section('admin_content')
    <div class="flex justify-between items-center mb-6 border-b border-gray-200 pb-4">
        <div>
            <h2 class="text-xl font-extrabold text-zinc-950 uppercase tracking-tight">Edit Category: {{ $category->name }}</h2>
        </div>
        <a href="{{ route('admin.categories') }}" class="text-xs font-bold text-zinc-500 hover:text-zinc-950">&larr; Back to Categories</a>
    </div>

    <div class="max-w-xl bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="name" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Category Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm font-bold text-zinc-800 focus:outline-none focus:border-zinc-500" />
                @error('name') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="bg-blue-50 border border-blue-200 p-4 rounded text-sm text-blue-800 font-semibold">
                <span class="block text-[10px] font-black uppercase tracking-wider text-blue-500 mb-1">Note on Slugs</span>
                The category slug (<code class="font-mono">{{ $category->slug }}</code>) will automatically regenerate if you change the category name. If you use this category heavily in SEO URLs, changing the name might break old links.
            </div>

            <button type="submit" class="w-full bg-zinc-950 text-white font-extrabold py-3.5 rounded text-xs uppercase tracking-widest hover:bg-zinc-800 transition duration-150 shadow-md">
                Update Category
            </button>
        </form>
    </div>
@endsection
