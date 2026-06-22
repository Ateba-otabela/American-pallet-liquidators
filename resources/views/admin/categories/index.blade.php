@extends('layouts.admin')

@section('admin_content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-extrabold text-zinc-950 uppercase tracking-tight">Manage Categories</h2>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-md font-bold mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-md font-bold mb-6 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <!-- Categories List (Left) -->
        <div class="lg:col-span-2 bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-black text-zinc-950 uppercase tracking-widest text-[10px]">Name</th>
                        <th class="px-6 py-4 font-black text-zinc-950 uppercase tracking-widest text-[10px]">Products</th>
                        <th class="px-6 py-4 font-black text-zinc-950 uppercase tracking-widest text-[10px] text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4">
                                <span class="font-bold text-zinc-900 block">{{ $category->name }}</span>
                                <span class="text-xs text-zinc-400 font-mono">{{ $category->slug }}</span>
                            </td>
                            <td class="px-6 py-4 text-zinc-500 font-semibold">
                                {{ $category->products_count }} item(s)
                            </td>
                            <td class="px-6 py-4 text-right space-x-3">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 uppercase tracking-wider">Edit</a>
                                
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this category? Products currently in this category will still exist but should be reassigned.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-800 uppercase tracking-wider">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-zinc-500 font-semibold text-sm">
                                No categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            @if($categories->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>

        <!-- Add Category Form (Right) -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
            <h3 class="text-sm font-black uppercase tracking-wider text-zinc-900 border-b border-gray-100 pb-3 mb-4">Add New Category</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-xs font-black uppercase tracking-wider text-zinc-900 mb-1.5">Category Name *</label>
                    <input type="text" id="name" name="name" required class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-sm font-bold text-zinc-800 focus:outline-none focus:border-zinc-500" placeholder="e.g. Health & Beauty" />
                    @error('name') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <button type="submit" class="w-full bg-zinc-950 text-white font-extrabold py-3 rounded text-xs uppercase tracking-widest hover:bg-zinc-800 transition duration-150 shadow-md">
                    Create Category
                </button>
            </form>
        </div>
    </div>
@endsection
