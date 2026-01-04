@extends('admin.layouts.app')

@section('title', 'Edit Payment Method')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-semibold mb-4">Edit Payment Method</h1>

    <form action="{{ route('admin.payment-methods.update', $paymentMethod) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name"
                   value="{{ old('name', $paymentMethod->name) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('name')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Type -->
        <div class="mb-4">
            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
            <select name="type" id="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">-- Select Type --</option>
                <option value="bank" {{ old('type', $paymentMethod->type) == 'bank' ? 'selected' : '' }}>Bank</option>
                <option value="digital" {{ old('type', $paymentMethod->type) == 'digital' ? 'selected' : '' }}>Digital</option>
            </select>
            @error('type')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Account Number -->
        <div class="mb-4">
            <label for="account_number" class="block text-sm font-medium text-gray-700">Account Number</label>
            <input type="text" name="account_number" id="account_number"
                   value="{{ old('account_number', $paymentMethod->account_number) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <!-- Account Name -->
        <div class="mb-4">
            <label for="account_name" class="block text-sm font-medium text-gray-700">Account Name</label>
            <input type="text" name="account_name" id="account_name"
                   value="{{ old('account_name', $paymentMethod->account_name) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <!-- QRIS Image -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Current QRIS Image</label>
            @if($paymentMethod->qris_image)
                <img src="{{ asset('storage/'.$paymentMethod->qris_image) }}" class="w-32 h-32 object-cover mb-2 rounded">
            @else
                <p class="text-gray-500">No image uploaded.</p>
            @endif
            <input type="file" name="qris_image" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <!-- Active Status -->
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_active" value="1" 
                       {{ old('is_active', $paymentMethod->is_active) ? 'checked' : '' }}>
                <span class="ml-2">Active</span>
            </label>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Update Payment Method
            </button>
        </div>
    </form>
</div>
@endsection
