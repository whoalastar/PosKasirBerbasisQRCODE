<!-- resources/views/admin/payment-methods/create.blade.php -->

@extends('admin.layouts.app')

@section('title', 'Add Payment Method')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Add Payment Method</h1>

@if ($errors->any())
<div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.payment-methods.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <div>
        <label class="block text-gray-700">Name</label>
        <input type="text" name="name" value="{{ old('name') }}" class="border px-3 py-2 rounded w-full">
    </div>
    <div>
        <label class="block text-gray-700">QRIS Image</label>
        <input type="file" name="qris_image" class="border px-3 py-2 rounded w-full">
    </div>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create Payment Method</button>
</form>
@endsection
