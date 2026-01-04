<!-- resources/views/admin/menus/show.blade.php -->

@extends('admin.layouts.app')

@section('title', 'Menu Details')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Menu Details</h1>

<div class="bg-white shadow rounded-lg p-6 space-y-6">
    <!-- Menu Name -->
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Name</h3>
        <p class="text-gray-700">{{ $menu->name }}</p>
    </div>

    <!-- Category -->
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Category</h3>
        <p class="text-gray-700">{{ $menu->category->name ?? '-' }}</p>
    </div>

    <!-- Description -->
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
        <div class="text-gray-700 bg-gray-50 p-3 rounded border">
            @if($menu->description)
                <p class="whitespace-pre-line">{{ $menu->description }}</p>
            @else
                <p class="text-gray-500 italic">No description provided</p>
            @endif
        </div>
    </div>

    <!-- Price -->
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Price</h3>
        <p class="text-gray-700 text-xl font-semibold">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
    </div>

    <!-- Stock -->
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Stock</h3>
        <p class="text-gray-700">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $menu->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $menu->stock }} {{ $menu->stock == 1 ? 'item' : 'items' }}
            </span>
        </p>
    </div>

    <!-- Availability Status -->
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Status</h3>
        <p class="text-gray-700">
            @if(isset($menu->is_available))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $menu->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $menu->is_available ? 'Available' : 'Unavailable' }}
                </span>
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    Status not set
                </span>
            @endif
        </p>
    </div>

    <!-- Image -->
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Image</h3>
        @if($menu->image)
            <div class="mt-2">
                <img src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->name }}" class="w-64 h-64 object-cover rounded-lg shadow-md">
            </div>
        @else
            <p class="text-gray-500 italic">No image uploaded</p>
        @endif
    </div>

    <!-- Action Buttons -->
    <div class="flex space-x-3 pt-4 border-t">
        <a href="{{ route('admin.menus.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
            Back to List
        </a>
        <a href="{{ route('admin.menus.edit', $menu) }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
            Edit Menu
        </a>
    </div>
</div>
@endsection