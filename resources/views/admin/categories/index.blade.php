<!-- resources/views/admin/categories/index.blade.php -->

@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-semibold">Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add Category</a>
</div>

@if(session('success'))
<div class="bg-green-100 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</div>
@endif

<div class="overflow-x-auto bg-white shadow rounded-lg">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Name</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Description</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Active</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Menus Count</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($categories as $category)
            <tr>
                <td class="px-4 py-2">{{ $category->name }}</td>
                <td class="px-4 py-2">{{ $category->description ?? '-' }}</td>
                <td class="px-4 py-2">
                    @if($category->is_active)
                        <span class="px-2 py-1 bg-green-200 text-green-800 text-xs rounded">Active</span>
                    @else
                        <span class="px-2 py-1 bg-gray-200 text-gray-800 text-xs rounded">Inactive</span>
                    @endif
                </td>
                <td class="px-4 py-2">{{ $category->menus_count }}</td>
                <td class="px-4 py-2 flex gap-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Edit</a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-2 text-center text-gray-500">No categories found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $categories->links() }}
</div>
@endsection
