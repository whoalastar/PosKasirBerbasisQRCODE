@extends('user.layouts.app')

@section('title', 'Selamat Datang - EHF RESTO')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-cyan-50">
    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-400/20 to-cyan-400/20"></div>
        <div class="relative max-w-7xl mx-auto px-4 py-16 sm:py-24">
            <div class="text-center space-y-8">
                <!-- Icon Hero -->
                <div class="inline-flex items-center justify-center w-32 h-32 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full shadow-2xl mb-8 transform hover:scale-105 transition-transform duration-300">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                    </svg>
                </div>
                
                <div class="space-y-6">
                    <h1 class="text-4xl md:text-7xl font-bold text-gray-900 leading-tight">
                        Selamat Datang di
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-cyan-500 animate-pulse">
                            EHF RESTO
                        </span>
                    </h1>
                    
                    <p class="text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                        Nikmati pengalaman kuliner modern dengan sistem pemesanan digital. 
                        <span class="text-blue-600 font-semibold">Scan QR code</span> di meja Anda untuk mulai memesan!
                    </p>
                </div>

                <!-- Call to Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mt-12">
                    <button id="scanQRBtn" 
                           class="group inline-flex items-center px-10 py-5 bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-bold text-lg rounded-2xl hover:from-blue-600 hover:to-cyan-600 transform hover:scale-105 transition-all duration-300 shadow-2xl hover:shadow-blue-200">
                        <svg class="w-6 h-6 mr-3 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11a2 2 0 01-2 2H8a2 2 0 01-2-2V9a2 2 0 012-2h8a2 2 0 012 2v7zM5 15v4a2 2 0 002 2h10a2 2 0 002-2v-4"/>
                        </svg>
                        Buka Kamera & Scan QR
                    </button>
                    
                    <a href="{{ route('scan.instructions') }}" 
                       class="inline-flex items-center px-8 py-4 bg-white text-gray-700 font-semibold rounded-xl hover:bg-gray-50 border-2 border-gray-200 hover:border-blue-300 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Panduan Scan QR
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Mengapa Memilih <span class="text-blue-500">Sistem Digital</span> Kami?
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Teknologi modern untuk pengalaman kuliner yang lebih mudah dan menyenangkan
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="group text-center p-8 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl mb-6 group-hover:animate-bounce">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Scan Mudah</h3>
                    <p class="text-gray-600">Gunakan kamera ponsel Anda untuk memindai QR code di meja dengan mudah dan cepat</p>
                </div>
                
                <div class="group text-center p-8 bg-gradient-to-br from-cyan-50 to-cyan-100 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-cyan-500 to-cyan-600 rounded-2xl mb-6 group-hover:animate-bounce">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Menu Digital</h3>
                    <p class="text-gray-600">Jelajahi menu lengkap dengan foto, deskripsi detail, dan harga yang selalu update</p>
                </div>
                
                <div class="group text-center p-8 bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-2xl mb-6 group-hover:animate-bounce">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pesan Cepat</h3>
                    <p class="text-gray-600">Pesan makanan favorit Anda dalam hitungan detik tanpa perlu menunggu pelayan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Step by Step Section -->
    <div class="py-20 bg-gradient-to-br from-blue-50 to-cyan-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Cara <span class="text-blue-500">Mudah</span> Memesan
                </h2>
                <p class="text-xl text-gray-600">Hanya 3 langkah sederhana untuk menikmati makanan favorit Anda</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="relative text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-2xl font-bold rounded-full mb-6 shadow-xl">1</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Scan QR Code</h3>
                    <p class="text-gray-600">Arahkan kamera ponsel ke QR code di meja Anda</p>
                    <div class="hidden md:block absolute top-10 -right-4 text-blue-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </div>

                <div class="relative text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-2xl font-bold rounded-full mb-6 shadow-xl">2</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pilih Menu</h3>
                    <p class="text-gray-600">Browse menu digital dan pilih makanan yang Anda inginkan</p>
                    <div class="hidden md:block absolute top-10 -right-4 text-blue-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </div>

                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-2xl font-bold rounded-full mb-6 shadow-xl">3</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Bayar & Nikmati</h3>
                    <p class="text-gray-600">Lakukan pembayaran dan tunggu pesanan Anda datang</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-20 bg-gradient-to-r from-blue-500 to-cyan-500">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                Siap untuk Memesan?
            </h2>
            <p class="text-xl text-blue-100 mb-8">
                Mulai pengalaman kuliner digital Anda sekarang juga!
            </p>
            
            <button id="scanQRBtnBottom" 
                   class="inline-flex items-center px-12 py-6 bg-white text-blue-500 font-bold text-xl rounded-2xl hover:bg-gray-50 transform hover:scale-105 transition-all duration-300 shadow-2xl hover:shadow-white/25">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Buka Kamera Sekarang
            </button>
        </div>
    </div>
</div>

<!-- QR Scanner Modal -->
<div id="qrScannerModal" class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-3xl p-8 m-4 max-w-md w-full">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Scan QR Code</h3>
            <p class="text-gray-600">Arahkan kamera ke QR code di meja Anda</p>
        </div>

        <div id="qrReader" class="bg-gray-100 rounded-2xl overflow-hidden mb-6" style="height: 300px;"></div>

        

            <button id="closeScannerBtn" class="w-full bg-gray-200 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-300 transition-all duration-200">
                Tutup Scanner
            </button>
        </div>
    </div>
</div>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.animate-gradient {
    background-size: 400% 400%;
    animation: gradient 8s ease infinite;
}

#qrReader {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6b7280;
    font-size: 14px;
}

#qrReader video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 1rem;
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const scanButtons = document.querySelectorAll('#scanQRBtn, #scanQRBtnBottom');
    const scannerModal = document.getElementById('qrScannerModal');
    const closeScannerBtn = document.getElementById('closeScannerBtn');
    const tableCodeInput = document.getElementById('tableCodeInput');
    const submitTableCode = document.getElementById('submitTableCode');
    
    let html5QrCode;
    let isScanning = false;

    // Open scanner modal
    scanButtons.forEach(btn => {
        btn.addEventListener('click', openScanner);
    });

    function openScanner() {
        scannerModal.classList.remove('hidden');
        startQRScanner();
    }

    // Close scanner modal
    closeScannerBtn.addEventListener('click', closeScanner);
    
    // Close modal when clicking outside
    scannerModal.addEventListener('click', (e) => {
        if (e.target === scannerModal) {
            closeScanner();
        }
    });

    function closeScanner() {
        scannerModal.classList.add('hidden');
        stopQRScanner();
    }

    // Start QR Scanner
    function startQRScanner() {
        if (isScanning) return;
        
        const qrReader = document.getElementById('qrReader');
        qrReader.innerHTML = 'Memulai kamera...';
        
        html5QrCode = new Html5Qrcode("qrReader");
        
        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                const cameraId = devices[0].id;
                
                html5QrCode.start(
                    cameraId,
                    {
                        fps: 10,
                        qrbox: { width: 250, height: 250 }
                    },
                    (decodedText, decodedResult) => {
                        console.log(`QR Code detected: ${decodedText}`);
                        handleQRResult(decodedText);
                    },
                    (errorMessage) => {
                        // Handle scan errors silently
                    }
                ).then(() => {
                    isScanning = true;
                }).catch(err => {
                    console.error('Error starting scanner:', err);
                    qrReader.innerHTML = `
                        <div class="text-center p-4">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="text-sm">Gagal membuka kamera</p>
                            <p class="text-xs text-gray-500 mt-1">Pastikan izin kamera sudah diberikan</p>
                        </div>
                    `;
                });
            } else {
                qrReader.innerHTML = `
                    <div class="text-center p-4">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <p class="text-sm">Kamera tidak ditemukan</p>
                        <p class="text-xs text-gray-500 mt-1">Gunakan input manual di bawah</p>
                    </div>
                `;
            }
        }).catch(err => {
            console.error('Error getting cameras:', err);
            qrReader.innerHTML = `
                <div class="text-center p-4">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p class="text-sm">Error mengakses kamera</p>
                    <p class="text-xs text-gray-500 mt-1">Gunakan input manual di bawah</p>
                </div>
            `;
        });
    }

    // Stop QR Scanner
    function stopQRScanner() {
        if (html5QrCode && isScanning) {
            html5QrCode.stop().then(() => {
                html5QrCode.clear();
                isScanning = false;
            }).catch(err => {
                console.error('Error stopping scanner:', err);
                isScanning = false;
            });
        }
    }

    // Handle QR scan result
    function handleQRResult(qrText) {
        stopQRScanner();
        closeScanner();
        
        // Try to extract table code from URL or direct code
        let tableCode = '';
        
        if (qrText.includes('table=') || qrText.includes('/table/')) {
            // Extract from URL
            const urlMatch = qrText.match(/table[=/]([A-Z0-9]+)/i);
            if (urlMatch) {
                tableCode = urlMatch[1];
            }
        } else {
            // Direct table code
            tableCode = qrText.trim();
        }
        
        if (tableCode) {
            redirectToTable(tableCode);
        } else {
            alert('QR Code tidak valid. Silakan coba lagi atau masukkan kode meja manual.');
        }
    }

    // Manual table code submission
    submitTableCode.addEventListener('click', () => {
        const tableCode = tableCodeInput.value.trim().toUpperCase();
        if (tableCode) {
            closeScanner();
            redirectToTable(tableCode);
        } else {
            alert('Silakan masukkan kode meja terlebih dahulu.');
        }
    });

    // Enter key for manual input
    tableCodeInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            submitTableCode.click();
        }
    });

    // Redirect to table menu
    function redirectToTable(tableCode) {
        // Show loading
        document.body.style.cursor = 'wait';
        
        // Simulate redirect (adjust URL pattern according to your routing)
        const url = `/table/${tableCode}`;
        
        // You can also try different URL patterns:
        // const url = `/menu?table=${tableCode}`;
        // const url = `/order/${tableCode}`;
        
        window.location.href = url;
    }

    // Add floating animations to hero elements
    setTimeout(() => {
        const heroIcon = document.querySelector('.text-center .w-32');
        if (heroIcon) {
            heroIcon.classList.add('animate-float');
        }
    }, 1000);
});
</script>
@endsection