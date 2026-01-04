@extends('user.layouts.app')

@section('title', 'Cara Scan QR Code - Restoran')

@section('content')
<div class="max-w-lg mx-auto px-4 py-6">
    <!-- Header -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-14 h-14 bg-blue-100 rounded-full mb-4">
            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M12 12h-4.01M12 12v4m0 0h-4.01M12 16h-4.01"></path>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-3">Cara Scan QR Code</h1>
        <p class="text-base text-gray-600">
            Ikuti langkah mudah ini untuk mengakses menu digital dan mulai pesan makanan
        </p>
    </div>

    <!-- Steps -->
    <div class="space-y-4 mb-8">
        <!-- Step 1 -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-sm font-bold text-blue-600">1</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Cari QR Code</h3>
                    <p class="text-sm text-gray-600 mb-3">Cari stiker atau kartu QR code di meja Anda. Biasanya ada di tengah meja atau di tempat yang mudah terlihat.</p>
                    <div class="bg-blue-50 p-3 rounded-md">
                        <p class="text-xs text-blue-700 flex items-start">
                            <svg class="w-4 h-4 mr-1 mt-0.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            QR code berisi nomor meja dan langsung terhubung ke halaman pemesanan
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-sm font-bold text-blue-600">2</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Buka Kamera</h3>
                    <p class="text-sm text-gray-600 mb-3">Buka aplikasi kamera di HP Anda. Sebagian besar HP sekarang sudah bisa scan QR code otomatis.</p>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="bg-gray-50 p-3 rounded-md text-center">
                            <span class="text-lg">📱</span>
                            <p class="text-xs font-medium mt-1">iPhone</p>
                            <p class="text-xs text-gray-500">Buka Kamera</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-md text-center">
                            <span class="text-lg">🤖</span>
                            <p class="text-xs font-medium mt-1">Android</p>
                            <p class="text-xs text-gray-500">Kamera atau Google Lens</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-sm font-bold text-blue-600">3</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Arahkan ke QR Code</h3>
                    <p class="text-sm text-gray-600 mb-3">Arahkan kamera ke QR code sampai terlihat jelas di layar. HP akan otomatis mendeteksi.</p>
                    <div class="bg-green-50 p-3 rounded-md border border-green-100">
                        <p class="text-xs text-green-700 flex items-start">
                            <svg class="w-4 h-4 mr-1 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Notifikasi atau link akan muncul ketika berhasil di-scan
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-sm font-bold text-blue-600">4</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Buka Menu Digital</h3>
                    <p class="text-sm text-gray-600 mb-3">Tap notifikasi atau link untuk membuka menu digital di browser HP Anda.</p>
                    <div class="bg-blue-50 p-3 rounded-md border border-blue-100">
                        <p class="text-xs text-blue-700 flex items-start">
                            <svg class="w-4 h-4 mr-1 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Anda akan diarahkan ke halaman pemesanan khusus meja Anda
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 5 -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-sm font-bold text-blue-600">5</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Pesan Makanan</h3>
                    <p class="text-sm text-gray-600 mb-3">Pilih menu, tambahkan catatan khusus, pilih metode pembayaran, dan kirim pesanan Anda.</p>
                    <div class="bg-purple-50 p-3 rounded-md border border-purple-100">
                        <p class="text-xs text-purple-700 flex items-start">
                            <svg class="w-4 h-4 mr-1 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Pesanan akan langsung dikirim ke dapur untuk diproses
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Troubleshooting -->
    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6">
        <h3 class="text-base font-semibold text-amber-800 mb-3 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            Susah Scan QR Code?
        </h3>
        <div class="space-y-2">
            <div class="flex items-start space-x-2 text-sm text-amber-700">
                <span class="text-amber-600 mt-1">•</span>
                <span>Pastikan kamera bersih dan fokus</span>
            </div>
            <div class="flex items-start space-x-2 text-sm text-amber-700">
                <span class="text-amber-600 mt-1">•</span>
                <span>Cari tempat dengan cahaya yang cukup</span>
            </div>
            <div class="flex items-start space-x-2 text-sm text-amber-700">
                <span class="text-amber-600 mt-1">•</span>
                <span>Jarak HP 15-30 cm dari QR code</span>
            </div>
            <div class="flex items-start space-x-2 text-sm text-amber-700">
                <span class="text-amber-600 mt-1">•</span>
                <span>Coba pakai aplikasi QR scanner</span>
            </div>
            <div class="flex items-start space-x-2 text-sm text-amber-700">
                <span class="text-amber-600 mt-1">•</span>
                <span>Minta bantuan staff jika masih kesulitan</span>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="text-center">
        <a href="{{ route('home') }}" 
           class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors duration-200 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection