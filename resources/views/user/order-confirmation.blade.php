@extends('user.layouts.app')

@section('title', 'Konfirmasi Pesanan - EHF RESTO')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <!-- Success Animation -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4 animate-pulse">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">
            Terima kasih, <span class="text-blue-600">{{ $order->customer_name }}</span>!
        </h1>
        
        <p class="text-base text-gray-600 max-w-md mx-auto leading-relaxed">
            Pesanan Anda berhasil diterima dan sudah dikirim ke dapur. Makanan lezat akan segera siap!
        </p>
    </div>

    <!-- Order Status Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-cyan-600 p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold mb-2">Pesanan Dikonfirmasi</h2>
                    <div class="flex items-center space-x-4 text-blue-100 text-sm">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $order->created_at->format('H:i') }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 16h12a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"></path>
                            </svg>
                            Meja #{{ $order->table->table_number }}
                        </span>
                    </div>
                </div>
                
                <div class="text-right">
                    <div class="bg-white bg-opacity-20 rounded-lg px-3 py-2">
                        <div class="text-xs text-blue-100">No. Pesanan</div>
                        <div class="text-lg font-bold">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 rounded-lg p-3">
                    <div class="flex items-center mb-2">
                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        <span class="font-medium text-gray-700 text-sm">Total Bayar</span>
                    </div>
                    <div class="text-lg font-bold text-gray-900">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</div>
                </div>
                
                <div class="bg-cyan-50 rounded-lg p-3">
                    <div class="flex items-center mb-2">
                        <svg class="w-4 h-4 mr-2 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span class="font-medium text-gray-700 text-sm">Status Pesanan</span>
                    </div>
                    <div class="text-sm font-bold capitalize
                        {{ $order->status === 'confirmed' ? 'text-blue-600' : ($order->status === 'preparing' ? 'text-orange-600' : ($order->status === 'ready' ? 'text-green-600' : ($order->status === 'completed' ? 'text-green-700' : 'text-gray-600'))) }}">
                        @switch($order->status)
                            @case('confirmed')
                                Dikonfirmasi
                                @break
                            @case('preparing')
                                Sedang Dimasak
                                @break
                            @case('ready')
                                Siap Disajikan
                                @break
                            @case('completed')
                                Selesai
                                @break
                            @default
                                {{ ucfirst($order->status) }}
                        @endswitch
                    </div>
                </div>
                
                <div class="bg-indigo-50 rounded-lg p-3">
                    <div class="flex items-center mb-2">
                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <span class="font-medium text-gray-700 text-sm">Metode Bayar</span>
                    </div>
                    <div class="text-sm font-bold text-gray-900">{{ $order->paymentMethod->name ?? 'Belum Dipilih' }}</div>
                </div>
            </div>
            
            <!-- Payment Status -->
            <div class="mt-4 p-3 rounded-lg border-2 border-dashed 
                {{ $order->payment_status === 'paid' ? 'border-green-300 bg-green-50' : ($order->payment_status === 'pending' ? 'border-yellow-300 bg-yellow-50' : 'border-gray-300 bg-gray-50') }}">
                <div class="flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2 
                        {{ $order->payment_status === 'paid' ? 'text-green-600' : ($order->payment_status === 'pending' ? 'text-yellow-600' : 'text-gray-600') }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    <span class="font-semibold text-sm
                        {{ $order->payment_status === 'paid' ? 'text-green-800' : ($order->payment_status === 'pending' ? 'text-yellow-800' : 'text-gray-800') }}">
                        Status Pembayaran: 
                        @switch($order->payment_status)
                            @case('paid')
                                Sudah Lunas
                                @break
                            @case('pending')
                                Menunggu Bayar
                                @break
                            @default
                                {{ ucfirst($order->payment_status) }}
                        @endswitch
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                Pesanan Anda
            </h3>
        </div>
        
        <div class="p-4">
            <div class="space-y-3">
                @foreach($order->orderItems as $item)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-gray-900">{{ $item->menu->name }}</h4>
                        <div class="flex items-center space-x-3 mt-1 text-xs text-gray-600">
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                {{ $item->quantity }}x
                            </span>
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                Rp{{ number_format($item->unit_price, 0, ',', '.') }}
                            </span>
                        </div>
                        @if($item->notes)
                        <div class="mt-2 p-2 bg-blue-50 rounded border border-blue-200">
                            <div class="flex items-start">
                                <svg class="w-3 h-3 mr-1 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span class="text-blue-800 text-xs">{{ $item->notes }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="text-right ml-3">
                        <div class="text-lg font-bold text-gray-900">Rp{{ number_format($item->total_price, 0, ',', '.') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Order Notes -->
    @if($order->notes)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Catatan Khusus
        </h3>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
            <p class="text-blue-800 text-sm">{{ $order->notes }}</p>
        </div>
    </div>
    @endif

    <!-- Next Steps -->
    <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-200 p-4 mb-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-3 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Apa yang Terjadi Selanjutnya?
        </h3>
        
        <div class="space-y-3">
            <div class="flex items-start space-x-3">
                <div class="bg-blue-100 rounded-full p-2 mt-0.5">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-blue-900 text-sm">Pesanan Diproses</h4>
                    <p class="text-blue-700 text-xs">Pesanan Anda sedang dimasak di dapur kami</p>
                </div>
            </div>
            
            <div class="flex items-start space-x-3">
                <div class="bg-yellow-100 rounded-full p-2 mt-0.5">
                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-blue-900 text-sm">Waktu Persiapan</h4>
                    <p class="text-blue-700 text-xs">Estimasi 15-25 menit</p>
                </div>
            </div>
            
            <div class="flex items-start space-x-3">
                <div class="bg-green-100 rounded-full p-2 mt-0.5">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-blue-900 text-sm">Siap Disajikan</h4>
                    <p class="text-blue-700 text-xs">Kami akan memberitahu ketika sudah siap</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="space-y-3">
        <a href="{{ route('user.order.receipt', $order->id) }}" 
           class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-cyan-600 transition-all duration-200 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Lihat Struk
        </a>
        
        <div class="grid grid-cols-2 gap-3">
            <button onclick="window.print()" 
                    class="inline-flex items-center justify-center px-4 py-3 bg-white border border-blue-300 text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak
            </button>
            
            <a href="{{ route('home') }}" 
               class="inline-flex items-center justify-center px-4 py-3 bg-white border border-gray-300 text-gray-600 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Beranda
            </a>
        </div>
    </div>
</div>
@endsection