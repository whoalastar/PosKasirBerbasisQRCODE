<!-- resources/views/admin/payment-methods/show.blade.php -->

@extends('admin.layouts.app')

@section('title', 'Payment Method Details')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Payment Method Details</h1>

<div class="bg-white shadow rounded-lg p-6 space-y-4">
    <div>
        <strong>Name:</strong> {{ $paymentMethod->name }}
    </div>
    <div>
        <strong>Type:</strong> {{ ucfirst($paymentMethod->type) }}
    </div>
    <div>
        <strong>Account Number:</strong> 
        {{ $paymentMethod->account_number ?? '-' }}
    </div>
    <div>
        <strong>Account Name:</strong> 
        {{ $paymentMethod->account_name ?? '-' }}
    </div>
    <div>
        <strong>Status:</strong>
        @if($paymentMethod->is_active)
            <span class="px-2 py-1 bg-green-100 text-green-700 rounded">Active</span>
        @else
            <span class="px-2 py-1 bg-red-100 text-red-700 rounded">Inactive</span>
        @endif
    </div>
    <div>
        <strong>QRIS Image:</strong><br>
        @if($paymentMethod->qris_image)
            <img src="{{ asset('storage/'.$paymentMethod->qris_image) }}" 
                 alt="{{ $paymentMethod->name }}" 
                 class="w-48 h-48 object-cover rounded">
        @else
            -
        @endif
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.payment-methods.edit', $paymentMethod) }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
           Edit
        </a>
        <a href="{{ route('admin.payment-methods.index') }}" 
           class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
           Back
        </a>
    </div>
</div>
@endsection
