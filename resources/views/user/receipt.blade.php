@extends('user.layouts.app')

@section('title', 'Struk - Pesanan #' . $order->id)

@push('styles')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        
        .print-only {
            display: block !important;
        }
        
        body {
            background: white !important;
            color: black !important;
        }
        
        .bg-gradient-to-r, .bg-gradient-to-br {
            background: white !important;
            color: black !important;
        }
        
        .shadow-lg, .shadow-md {
            box-shadow: none !important;
            border: 1px solid #ccc !important;
        }
    }
    
    .print-only {
        display: none;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Print Header (only visible when printing) -->
        <div class="print-only text-center mb-8 border-b-2 border-gray-800 pb-4">
            <h1 class="text-3xl font-bold mb-2">🍽️ EHF RESTO</h1>
            <p class="text-gray-600">Struk Digital</p>
            <p class="text-sm text-gray-500">Dicetak pada {{ now()->format('j F Y \p\u\k\u\l H:i') }}</p>
        </div>

        <!-- Receipt Header -->
        <div class="no-print text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 rounded-full mb-6 shadow-lg">
                <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Struk Pesanan</h1>
            <p class="text-lg sm:text-xl text-gray-600">Ringkasan lengkap pesanan Anda</p>
        </div>

        <!-- Receipt Content -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4 sm:p-6">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold mb-1">Struk #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h2>
                        <p class="text-blue-100 text-sm sm:text-base">{{ $order->created_at->format('j F Y \p\u\k\u\l H:i') }}</p>
                    </div>
                    
                    <div class="text-center sm:text-right">
                        <div class="bg-white bg-opacity-20 rounded-xl px-3 py-2 sm:px-4 sm:py-3">
                            <div class="text-xs sm:text-sm text-blue-100">Nomor Meja</div>
                            <div class="text-xl sm:text-2xl font-bold">#{{ $order->table->table_number }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer & Order Information -->
            <div class="p-4 sm:p-6 border-b border-gray-200">
                <div class="grid md:grid-cols-2 gap-6 sm:gap-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Informasi Pelanggan
                        </h3>
                        <div class="space-y-3 text-gray-700">
                            <div class="flex justify-between">
                                <span class="font-medium">Nama:</span>
                                <span class="text-right">{{ $order->customer_name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Meja:</span>
                                <span>#{{ $order->table->table_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Tanggal Pesan:</span>
                                <span>{{ $order->created_at->format('j M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Waktu Pesan:</span>
                                <span>{{ $order->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Status Pesanan
                        </h3>
                        <div class="space-y-3 text-gray-700">
                            <div class="flex justify-between items-center">
                                <span class="font-medium">Status Pesanan:</span>
                                <span class="px-3 py-1 rounded-full text-xs sm:text-sm font-medium
                                    {{ $order->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : 
                                       ($order->status === 'preparing' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($order->status === 'ready' ? 'bg-orange-100 text-orange-800' : 
                                       ($order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'))) }}">
                                    @switch($order->status)
                                        @case('confirmed')
                                            Dikonfirmasi
                                            @break
                                        @case('preparing')
                                            Sedang Disiapkan
                                            @break
                                        @case('ready')
                                            Siap
                                            @break
                                        @case('completed')
                                            Selesai
                                            @break
                                        @default
                                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    @endswitch
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium">Status Pembayaran:</span>
                                <span class="px-3 py-1 rounded-full text-xs sm:text-sm font-medium
                                    {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 
                                       ($order->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    @switch($order->payment_status)
                                        @case('paid')
                                            Lunas
                                            @break
                                        @case('pending')
                                            Menunggu
                                            @break
                                        @default
                                            Belum Bayar
                                    @endswitch
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Metode Pembayaran:</span>
                                <span class="text-right">{{ $order->paymentMethod->name ?? 'Belum Dipilih' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="p-4 sm:p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Daftar Pesanan ({{ $order->orderItems->count() }} {{ $order->orderItems->count() === 1 ? 'item' : 'items' }})
                </h3>

                <!-- Desktop Table -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-blue-200">
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Menu</th>
                                <th class="text-center py-3 px-4 font-semibold text-gray-700">Jumlah</th>
                                <th class="text-right py-3 px-4 font-semibold text-gray-700">Harga Satuan</th>
                                <th class="text-right py-3 px-4 font-semibold text-gray-700">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr class="border-b border-gray-100 hover:bg-blue-50 transition-colors">
                                <td class="py-4 px-4">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $item->menu->name }}</div>
                                        @if($item->notes)
                                        <div class="text-sm text-gray-600 mt-1 italic">
                                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            {{ $item->notes }}
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-800 rounded-full text-sm font-bold">
                                        {{ $item->quantity }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right font-medium text-gray-900">
                                    Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-4 text-right font-bold text-blue-600">
                                    Rp {{ number_format($item->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="lg:hidden space-y-4">
                    @foreach($order->orderItems as $item)
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1 pr-4">
                                <h4 class="font-semibold text-gray-900 text-sm sm:text-base">{{ $item->menu->name }}</h4>
                                @if($item->notes)
                                <p class="text-xs sm:text-sm text-gray-600 mt-1 italic">{{ $item->notes }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-blue-600">Rp {{ number_format($item->total_price, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="flex justify-between text-xs sm:text-sm text-gray-600">
                            <span>Jumlah: <span class="font-medium">{{ $item->quantity }}</span></span>
                            <span>Harga: <span class="font-medium">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</span></span>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="mt-8 border-t-2 border-blue-200 pt-6">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 sm:p-6 border border-blue-200">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Ringkasan Pesanan
                        </h4>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between text-gray-700">
                                <span>Subtotal ({{ $order->orderItems->sum('quantity') }} items):</span>
                                <span class="font-medium">Rp {{ number_format($order->orderItems->sum('total_price'), 0, ',', '.') }}</span>
                            </div>
                            
                            @php
                                $subtotal = $order->orderItems->sum('total_price');
                                $tax = $subtotal * 0.10; // 10% PPN
                                $service = $subtotal * 0.05; // 5% biaya layanan
                            @endphp
                            
                           
                            
                            <div class="border-t border-blue-300 pt-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg sm:text-xl font-bold text-gray-900">Total Pembayaran:</span>
                                    <span class="text-xl sm:text-2xl font-bold text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Notes -->
            @if($order->notes)
            <div class="px-4 sm:px-6 pb-6">
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <h4 class="font-semibold text-blue-900 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Permintaan Khusus:
                    </h4>
                    <p class="text-blue-800">{{ $order->notes }}</p>
                </div>
            </div>
            @endif

            <!-- Footer -->
            
        </div>

        <!-- Action Buttons -->
        <div class="no-print mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <button onclick="window.print()" 
                    class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                <span class="text-sm sm:text-base">Cetak Struk</span>
            </button>
            
            <button onclick="downloadReceipt()" 
                    class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="text-sm sm:text-base">Unduh PDF</span>
            </button>
            
            <a href="{{ route('user.order.confirmation', $order->id) }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm sm:text-base">Detail Pesanan</span>
            </a>
            
            <a href="{{ route('home') }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-xl hover:bg-gray-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="text-sm sm:text-base">Kembali ke Beranda</span>
            </a>
        </div>

        <!-- Thank You Message -->
        <div class="no-print mt-12 text-center bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 sm:p-8 border border-blue-200">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">Terima Kasih atas Pesanan Anda!</h3>
            <p class="text-gray-600 max-w-2xl mx-auto text-sm sm:text-base">
                Kami menghargai kepercayaan Anda dan berharap Anda menikmati pengalaman makan bersama kami. 
                Jangan ragu untuk berkunjung kembali!
            </p>
            <div class="mt-4 flex flex-col sm:flex-row gap-2 justify-center text-xs sm:text-sm text-gray-500">
                <span>🌟 Beri rating pengalaman Anda</span>
                <span class="hidden sm:inline">•</span>
                <span>📧 Kirim masukan</span>
                <span class="hidden sm:inline">•</span>
                <span>📱 Ikuti media sosial kami</span>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function downloadReceipt() {
    // Get the receipt content
    const receiptContent = document.querySelector('.bg-white.rounded-2xl').outerHTML;
    
    // Create a new window for printing/downloading
    const printWindow = window.open('', '_blank');
    
    const htmlContent = `
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Struk - Pesanan #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</title>
            <script src="https://cdn.tailwindcss.com"><\/script>
            <style>
                @media print {
                    .no-print { display: none !important; }
                    .print-only { display: block !important; }
                    body { background: white !important; color: black !important; }
                    .bg-gradient-to-r, .bg-gradient-to-br { background: white !important; color: black !important; }
                    .shadow-lg, .shadow-md { box-shadow: none !important; border: 1px solid #ccc !important; }
                }
                .print-only { display: none; }
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
            </style>
        </head>
        <body class="bg-white p-8">
            <div class="print-only text-center mb-8 border-b-2 border-gray-800 pb-4">
                <h1 class="text-3xl font-bold mb-2">🍽️ EHF RESTO</h1>
                <p class="text-gray-600">Struk Digital</p>
                <p class="text-sm text-gray-500">Diunduh pada ${new Date().toLocaleDateString('id-ID')} pukul ${new Date().toLocaleTimeString('id-ID')}</p>
            </div>
            <div class="max-w-4xl mx-auto">
                ${receiptContent}
            </div>
        </body>
        </html>`;
    
    printWindow.document.write(htmlContent);
    printWindow.document.close();
    
    // Wait for content to load then print
    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 500);
}

// Auto-focus print button on page load
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scroll to top when print is done
    window.addEventListener('afterprint', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    
    // Add loading animation for buttons
    const buttons = document.querySelectorAll('button, a');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Don't apply animation to link elements that navigate away
            if (this.tagName === 'A' && this.getAttribute('href') && !this.getAttribute('href').startsWith('#')) {
                return;
            }
            
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    });
    
    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + P for print
        if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
            e.preventDefault();
            window.print();
        }
        // Ctrl/Cmd + D for download
        if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
            e.preventDefault();
            downloadReceipt();
        }
    });
});
</script>
@endpush
@endsection