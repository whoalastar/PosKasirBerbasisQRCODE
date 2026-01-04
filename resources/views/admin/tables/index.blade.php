@extends('admin.layouts.app')

@section('title', 'Tables')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-semibold">Tables</h1>
    <div class="flex gap-2">
        <a href="{{ route('admin.tables.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add Table</a>
        
       
    </div>
</div>

@if(session('success'))
<div class="bg-green-100 text-green-800 p-3 mb-4 rounded border border-green-200">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-100 text-red-800 p-3 mb-4 rounded border border-red-200">
    {{ session('error') }}
</div>
@endif

<!-- Search -->
<form method="GET" class="mb-4 flex gap-2 items-end">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search table number" class="border px-3 py-2 rounded">
    <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Search</button>
    @if(request('search'))
    <a href="{{ route('admin.tables.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Clear</a>
    @endif
</form>

<div class="overflow-x-auto bg-white shadow rounded-lg">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Table Number</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Capacity</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">QR Code</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($tables as $table)
            <tr>
                <td class="px-4 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ $table->table_number }}</div>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ $table->capacity }} people</div>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    @if($table->barcode_path && file_exists(public_path($table->barcode_path)))
                        @php
                            $fileExtension = pathinfo($table->barcode_path, PATHINFO_EXTENSION);
                            $fileSize = file_exists(public_path($table->barcode_path)) ? filesize(public_path($table->barcode_path)) : 0;
                            $isValidFile = $fileSize > 0;
                        @endphp
                        
                        <div class="flex items-center gap-3">
                            <div class="qr-code-container">
                                @if($isValidFile)
                                    @if($fileExtension === 'svg')
                                        <div class="w-20 h-20 border border-gray-300 rounded bg-white p-1">
                                            <img src="{{ asset($table->barcode_path) }}" alt="QR Code SVG" class="w-full h-full object-contain">
                                        </div>
                                    @else
                                        <img src="{{ asset($table->barcode_path) }}" alt="QR Code PNG" class="w-20 h-20 object-contain border border-gray-300 rounded">
                                    @endif
                                @else
                                    <div class="w-20 h-20 bg-red-100 border border-red-300 rounded flex items-center justify-center">
                                        <span class="text-xs text-red-600">Invalid</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex flex-col gap-1">
                                <a href="{{ route('admin.tables.download-barcode', $table) }}" class="text-blue-600 hover:text-blue-800 text-xs">
                                    Download
                                </a>
                                <span class="text-xs text-gray-500">
                                    {{ strtoupper($fileExtension) }} ({{ number_format($fileSize / 1024, 1) }}KB)
                                </span>
                                @if(!$isValidFile)
                                    <span class="text-xs text-red-500">File corrupted</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <div class="w-20 h-20 bg-gray-100 border border-gray-300 rounded flex items-center justify-center">
                                <span class="text-xs text-gray-500">No QR</span>
                            </div>
                            <span class="text-sm text-gray-400">Not generated</span>
                        </div>
                    @endif
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <div class="flex flex-wrap gap-1">
                        <a href="{{ route('admin.tables.show', $table) }}" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300 text-xs">View</a>
                        <a href="{{ route('admin.tables.edit', $table) }}" class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs">Edit</a>
                        
                        <form action="{{ route('admin.tables.destroy', $table) }}" method="POST" onsubmit="return confirm('Delete this table and its QR code?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">Delete</button>
                        </form>
                        
                        <div class="relative inline-block">
                            <button type="button" onclick="toggleQrOptions({{ $table->id }})" class="px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs">
                                Generate QR ▾
                            </button>
                            <div id="qrOptions{{ $table->id }}" class="hidden absolute right-0 mt-1 w-40 bg-white rounded-md shadow-lg z-20 border">
                                <div class="py-1">
                                    <form action="{{ route('admin.tables.generate-barcode', $table) }}" method="POST" class="block">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">Auto Generate</button>
                                    </form>
                                    
                                    @if(extension_loaded('gd'))
                                    <form action="{{ route('admin.tables.generate-barcode-with-logo', $table) }}" method="POST" class="block">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">Enhanced QR</button>
                                    </form>
                                    @endif
                                    
                                    <a href="{{ route('admin.tables.debug-barcode', $table) }}" target="_blank" class="block w-full text-left px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">Debug Info</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <p class="text-lg">No tables found</p>
                        <p class="text-sm text-gray-400">
                            @if(request('search'))
                                Try adjusting your search terms
                            @else
                                Create your first table to get started
                            @endif
                        </p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $tables->withQueryString()->links() }}
</div>

@if(extension_loaded('gd'))
<div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
    <div class="flex items-center">
        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="text-sm text-blue-700">
            <strong>GD Extension Detected:</strong> Enhanced QR codes with text information are available.
        </span>
    </div>
</div>
@else
<div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
    <div class="flex items-center">
        <svg class="w-5 h-5 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
        </svg>
        <span class="text-sm text-yellow-700">
            <strong>GD Extension Not Available:</strong> Only basic QR codes can be generated. Install php-gd for enhanced features.
        </span>
    </div>
</div>
@endif

<script>
function toggleDropdown() {
    const dropdown = document.getElementById('regenerateDropdown');
    dropdown.classList.toggle('hidden');
}

function toggleQrOptions(tableId) {
    // Hide all other dropdowns first
    document.querySelectorAll('[id^="qrOptions"]').forEach(el => {
        if (el.id !== 'qrOptions' + tableId) {
            el.classList.add('hidden');
        }
    });
    
    // Toggle current dropdown
    const dropdown = document.getElementById('qrOptions' + tableId);
    dropdown.classList.toggle('hidden');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.relative')) {
        document.querySelectorAll('[id^="qrOptions"], #regenerateDropdown').forEach(el => {
            el.classList.add('hidden');
        });
    }
});

// Auto-hide alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s ease-out';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);
</script>
@endsection