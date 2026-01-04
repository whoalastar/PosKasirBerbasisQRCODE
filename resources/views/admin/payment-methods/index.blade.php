@extends('admin.layouts.app')

@section('title', 'Payment Methods')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-semibold">Payment Methods</h1>
    <a href="{{ route('admin.payment-methods.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add Payment Method</a>
</div>

@if(session('success'))
<div class="bg-green-100 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</div>
@endif

<div class="overflow-x-auto bg-white shadow rounded-lg">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 text-left text-sm text-gray-500">Name</th>
                <th class="px-4 py-2 text-left text-sm text-gray-500">Type</th>
                <th class="px-4 py-2 text-left text-sm text-gray-500">Account Number</th>
                <th class="px-4 py-2 text-left text-sm text-gray-500">Status</th>
                <th class="px-4 py-2 text-left text-sm text-gray-500">QRIS Image</th>
                <th class="px-4 py-2 text-left text-sm text-gray-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($paymentMethods as $method)
            <tr>
                <td class="px-4 py-2 font-medium">{{ $method->name }}</td>
                <td class="px-4 py-2 capitalize">{{ $method->type }}</td>
                <td class="px-4 py-2">{{ $method->account_number ?? '-' }}</td>
                <td class="px-4 py-2">
                    @if($method->is_active)
                        <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">Active</span>
                    @else
                        <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">Inactive</span>
                    @endif
                </td>
                <td class="px-4 py-2">
                    @if($method->qris_image)
                        <img src="{{ asset('storage/'.$method->qris_image) }}" alt="{{ $method->name }}" class="w-16 h-16 object-cover rounded">
                    @else
                        -
                    @endif
                </td>
                <td class="px-4 py-2 flex gap-2">
                    <a href="{{ route('admin.payment-methods.show', $method) }}" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">View</a>
                    <a href="{{ route('admin.payment-methods.edit', $method) }}" class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Edit</a>
                    <form action="{{ route('admin.payment-methods.destroy', $method) }}" method="POST" onsubmit="return confirm('Delete this payment method?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-2 text-center text-gray-500">No payment methods found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $paymentMethods->links() }}
</div>
@endsection
