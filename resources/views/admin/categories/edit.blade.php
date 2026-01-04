<!-- resources/views/admin/categories/edit.blade.php -->

@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Edit Category</h1>

@if ($errors->any())
<div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-gray-700">Name</label>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" class="border px-3 py-2 rounded w-full">
    </div>
    <div>
        <label class="block text-gray-700">Description</label>
        <textarea name="description" class="border px-3 py-2 rounded w-full">{{ old('description', $category->description) }}</textarea>
    </div>
    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
        <label class="text-gray-700">Active</label>
    </div>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Category</button>
</form>
@endsection
