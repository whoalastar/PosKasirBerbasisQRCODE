@extends('admin.layouts.app')

@section('title', 'Table Details')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-semibold">Table #{{ $table->table_number }}</h1>
    <a href="{{ route('admin.tables.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Back to Tables</a>
</div>

@if(session('success'))
<div class="bg-green-100 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="bg-red-100 text-red-800 p-2 mb-4 rounded">{{ session('error') }}</div>
@endif

<div class="bg-white shadow rounded-lg p-6">
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Table Information -->
        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-800">Table Information</h2>
            <div>
                <label class="block text-sm font-medium text-gray-600">Table Number</label>
                <p class="text-lg font-semibold">{{ $table->table_number }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600">Capacity</label>
                <p class="text-lg">{{ $table->capacity }} people</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600">Scan URL</label>
                <p class="text-sm text-blue-600 break-all">{{ url("/scan/{$table->table_number}") }}</p>
            </div>
        </div>

        <!-- QR Code Section -->
        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-800">QR Code</h2>

            @if($table->barcode_path && file_exists(public_path($table->barcode_path)))
                @php
                    $fileExtension = pathinfo($table->barcode_path, PATHINFO_EXTENSION);
                @endphp

                <div class="text-center">
                    <img src="{{ asset($table->barcode_path) }}" alt="QR Code" class="mx-auto border border-gray-200 rounded-lg p-2 w-40 h-40 object-contain">

                    <div class="mt-4 space-y-2">
                        <div class="flex gap-2 justify-center">
                            <a href="{{ route('admin.tables.download-barcode', $table) }}" 
                               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Download QR Code
                            </a>

                            <!-- Generate / Regenerate -->
                            <form action="{{ route('admin.tables.generate-barcode', $table) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                    Regenerate QR Code
                                </button>
                            </form>

                            @if(extension_loaded('gd'))
                            <form action="{{ route('admin.tables.generate-barcode-with-logo', $table) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                                    Enhanced QR
                                </button>
                            </form>
                            @endif
                        </div>

                        <div class="text-sm text-gray-500">
                            Type: {{ strtoupper($fileExtension) }}
                        </div>
                    </div>
                </div>

            @else
                <div class="text-center py-8">
                    <p class="text-gray-400 mb-4">QR Code not generated yet</p>
                    <form action="{{ route('admin.tables.generate-barcode', $table) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Generate QR Code
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-2 mt-6 pt-6 border-t">
        <a href="{{ route('admin.tables.edit', $table) }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Edit Table
        </a>
        <form action="{{ route('admin.tables.destroy', $table) }}" method="POST" 
              onsubmit="return confirm('Are you sure you want to delete this table?')" class="inline">
            @csrf
            @method('DELETE')
              <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Delete Table
            </button>
        </form>
    </div>
</div>
@endsection
