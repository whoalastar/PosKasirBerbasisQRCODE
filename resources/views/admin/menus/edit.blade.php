<!-- resources/views/admin/menus/edit.blade.php -->

@extends('admin.layouts.app')

@section('title', 'Edit Menu')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Edit Menu</h1>

@if ($errors->any())
<div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.menus.update', $menu) }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded shadow-md">
    @csrf
    @method('PUT')

    <!-- Name -->
    <div>
        <label class="block text-gray-700 font-medium mb-1">Name</label>
        <input type="text" name="name" value="{{ old('name', $menu->name) }}" class="border px-3 py-2 rounded w-full focus:ring focus:ring-indigo-200">
        @error('name')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Category -->
    <div>
        <label class="block text-gray-700 font-medium mb-1">Category</label>
        <select name="category_id" class="border px-3 py-2 rounded w-full focus:ring focus:ring-indigo-200">
            <option value="">Select Category</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $menu->category_id)==$category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
        @error('category_id')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Description -->
    <div>
        <label class="block text-gray-700 font-medium mb-1">Description</label>
        <textarea name="description" rows="4" class="border px-3 py-2 rounded w-full focus:ring focus:ring-indigo-200 resize-vertical" placeholder="Enter menu description...">{{ old('description', $menu->description) }}</textarea>
        @error('description')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Price -->
    <div>
        <label class="block text-gray-700 font-medium mb-1">Price</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $menu->price) }}" class="border px-3 py-2 rounded w-full focus:ring focus:ring-indigo-200">
        @error('price')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Stock -->
    <div>
        <label class="block text-gray-700 font-medium mb-1">Stock</label>
        <input type="number" name="stock" value="{{ old('stock', $menu->stock) }}" class="border px-3 py-2 rounded w-full focus:ring focus:ring-indigo-200">
        @error('stock')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Current Image -->
    <div>
        <label class="block text-gray-700 font-medium mb-1">Current Image</label>
        @if($menu->image)
            <img src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->name }}" class="w-32 h-32 object-cover rounded mb-2">
        @else
            <p class="text-gray-500 mb-2">No image uploaded</p>
        @endif
        <input type="file" name="image" class="border px-3 py-2 rounded w-full focus:ring focus:ring-indigo-200">
        @error('image')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Submit Button -->
    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 shadow transition">
        Update Menu
    </button>
</form>
@endsection