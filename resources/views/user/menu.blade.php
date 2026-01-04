@extends('user.layouts.app')

@section('title', 'Menu Meja #' . $table->table_number)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    <!-- Header -->
    <div class="bg-white shadow-lg border-b-4 border-blue-500 sticky top-0 z-40">
        <div class="max-w-4xl mx-auto px-4 py-4 sm:py-6">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full mb-3 shadow-lg">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V3"/>
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Meja #{{ $table->table_number }}</h1>
                <p class="text-sm sm:text-base text-gray-600">Pilih menu favorit Anda dan nikmati pengalaman kuliner terbaik</p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-3 sm:px-4 py-4 sm:py-6 pb-32 sm:pb-6">
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 sm:mb-6 rounded-r-lg shadow-md">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm sm:text-base">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Filter Kategori -->
        <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 mb-6 sm:mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">Pilih Kategori</h3>
            <div class="flex flex-wrap gap-2 sm:gap-3 justify-center">
                <button type="button" class="filter-btn px-4 py-2 sm:px-6 sm:py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full font-medium shadow-lg transform transition-all duration-200 hover:scale-105 active:scale-95 text-sm sm:text-base" data-category="all">
                    Semua Menu
                </button>
                @foreach($categories as $category)
                    <button type="button" class="filter-btn px-4 py-2 sm:px-6 sm:py-3 bg-gray-100 text-gray-700 rounded-full font-medium shadow-md transform transition-all duration-200 hover:scale-105 hover:bg-gray-200 active:scale-95 text-sm sm:text-base" data-category="{{ $category->id }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        </div>

        <form action="{{ route('user.order.store') }}" method="POST" id="orderForm">
            @csrf
            <input type="hidden" name="table_id" value="{{ $table->id }}">
            
            <!-- Customer Info Card -->
            <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 mb-6 sm:mb-8">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">Informasi Pemesan</h3>
                </div>
                <input type="text" name="customer_name" placeholder="Masukkan nama Anda..." class="w-full border-2 border-gray-200 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200 text-sm sm:text-base" required>
            </div>

            <div id="selectedItems"></div>

            <!-- Menu Items -->
            @foreach($categories as $category)
                <div class="category-section mb-6 sm:mb-8" data-category-id="{{ $category->id }}">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl p-4 sm:p-6 mb-4 sm:mb-6 shadow-lg">
                        <h2 class="text-xl sm:text-2xl font-bold text-white text-center category-title">{{ $category->name }}</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 category-group" data-category-id="{{ $category->id }}">
                        @foreach($category->menus as $menu)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                            <div class="relative">
                                @if($menu->image)
                                    <img src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->name }}" class="w-full h-40 sm:h-48 object-cover">
                                    <div class="absolute top-2 sm:top-3 right-2 sm:right-3 bg-white bg-opacity-95 rounded-full px-2 py-1 sm:px-3">
                                        <span class="text-xs sm:text-sm font-medium text-gray-700">Stok: {{ $menu->stock }}</span>
                                    </div>
                                @else
                                    <div class="w-full h-40 sm:h-48 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                        <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="p-4 sm:p-5">
                                <h3 class="font-bold text-base sm:text-lg text-gray-800 mb-2 line-clamp-2">{{ $menu->name }}</h3>
                                <p class="text-gray-600 text-xs sm:text-sm mb-3 line-clamp-2">{{ $menu->description }}</p>
                                
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-lg sm:text-xl font-bold text-blue-600">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                    <span class="text-xs sm:text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded-full">{{ $menu->stock }} tersisa</span>
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    <label class="text-xs sm:text-sm font-medium text-gray-700 flex-1">Jumlah:</label>
                                    <div class="flex items-center space-x-1 sm:space-x-2 bg-gray-50 rounded-xl p-1">
                                        <button type="button" class="quantity-btn minus w-8 h-8 bg-white rounded-lg shadow-sm flex items-center justify-center text-gray-600 hover:bg-gray-100 active:bg-blue-50" data-action="minus" data-target="quantity-{{ $menu->id }}">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                            </svg>
                                        </button>
                                        <input type="number" 
                                               id="quantity-{{ $menu->id }}"
                                               data-menu-id="{{ $menu->id }}" 
                                               data-menu-name="{{ $menu->name }}" 
                                               data-menu-price="{{ $menu->price }}" 
                                               class="menu-quantity w-10 sm:w-12 text-center border-0 bg-transparent font-medium text-sm sm:text-base" 
                                               value="0" 
                                               min="0" 
                                               max="{{ $menu->stock }}" readonly>
                                        <button type="button" class="quantity-btn plus w-8 h-8 bg-white rounded-lg shadow-sm flex items-center justify-center text-gray-600 hover:bg-gray-100 active:bg-blue-50" data-action="plus" data-target="quantity-{{ $menu->id }}" data-max="{{ $menu->stock }}">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- Additional Notes -->
            <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 mb-6">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-amber-500 to-yellow-500 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">Catatan Tambahan</h3>
                </div>
                <textarea name="notes" class="w-full border-2 border-gray-200 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200 resize-none text-sm sm:text-base" rows="3" placeholder="Tulis permintaan khusus di sini..."></textarea>
            </div>

            <!-- Payment Method (Hidden inputs for form) -->
            <input type="hidden" name="payment_method_id" id="selectedPaymentMethodId">
        </form>
    </div>

    <!-- Mobile Order Summary (Fixed Bottom) -->
    <div class="fixed bottom-0 left-0 right-0 bg-white shadow-2xl border-t-4 border-blue-500 p-4 z-50 sm:hidden">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-base font-semibold text-gray-800">Ringkasan Pesanan</h3>
            <div class="w-6 h-6 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center">
                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
        <div id="mobileOrderSummary" class="mb-3 max-h-20 overflow-y-auto">
            <p class="text-gray-500 text-center text-sm py-2">Belum ada item yang dipilih</p>
        </div>
        <div class="flex items-center justify-between mb-3">
            <span class="text-base font-bold text-gray-800">Total:</span>
            <span class="text-lg font-bold text-blue-600" id="mobileTotal">Rp 0</span>
        </div>
        <button type="button" class="w-full px-4 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl font-bold text-base shadow-lg transform transition-all duration-200 hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none" id="mobileOrderBtn" disabled>
            <span class="flex items-center justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0H17M9 19.5h.01M20 19.5h.01"/>
                </svg>
                Pesan Sekarang
            </span>
        </button>
    </div>

    <!-- Desktop Order Summary -->
    <div class="hidden sm:block bg-white rounded-2xl shadow-lg p-6 mb-6 sticky bottom-6 z-10 max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Ringkasan Pesanan</h3>
            <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
        <div id="orderSummary" class="space-y-2 mb-4 max-h-32 overflow-y-auto">
            <p class="text-gray-500 text-center py-4">Belum ada item yang dipilih</p>
        </div>
        <div class="border-t pt-4">
            <div class="flex justify-between items-center text-xl font-bold text-gray-800" id="totalAmount">
                <span>Total:</span>
                <span class="text-blue-600">Rp 0</span>
            </div>
        </div>
        <div class="mt-4">
            <button type="button" class="w-full px-6 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-2xl font-bold text-lg shadow-lg transform transition-all duration-200 hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none" id="orderBtn" disabled>
                <span class="flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0H17M9 19.5h.01M20 19.5h.01"/>
                    </svg>
                    Pesan Sekarang
                </span>
            </button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Pesanan -->
<div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden p-4">
    <div class="bg-white rounded-3xl p-6 sm:p-8 w-full max-w-md max-h-screen overflow-y-auto">
        <div class="text-center mb-6">
            <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-2">Konfirmasi Pesanan</h3>
            <p class="text-sm sm:text-base text-gray-600">Periksa kembali pesanan Anda</p>
        </div>

        <div class="space-y-4 mb-6">
            <div class="bg-gray-50 rounded-xl p-4">
                <h4 class="font-semibold text-gray-800 mb-2 text-sm sm:text-base">Informasi Pemesan:</h4>
                <p id="confirmCustomerName" class="text-gray-600 text-sm sm:text-base"></p>
            </div>

            <div class="bg-gray-50 rounded-xl p-4">
                <h4 class="font-semibold text-gray-800 mb-3 text-sm sm:text-base">Items Pesanan:</h4>
                <div id="confirmOrderItems" class="space-y-2"></div>
                <div class="border-t mt-3 pt-3">
                    <div class="flex justify-between font-bold text-base sm:text-lg">
                        <span>Total:</span>
                        <span id="confirmTotal" class="text-blue-600"></span>
                    </div>
                </div>
            </div>

            <div id="confirmNotes" class="bg-gray-50 rounded-xl p-4 hidden">
                <h4 class="font-semibold text-gray-800 mb-2 text-sm sm:text-base">Catatan:</h4>
                <p id="confirmNotesText" class="text-gray-600 text-sm sm:text-base"></p>
            </div>
        </div>

        <div class="space-y-3">
            <button type="button" id="proceedToPayment" class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-emerald-700 transition-all duration-200 text-sm sm:text-base">
                Lanjut ke Pembayaran
            </button>
            <button type="button" id="cancelOrder" class="w-full bg-gray-200 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-300 transition-all duration-200 text-sm sm:text-base">
                Batalkan
            </button>
        </div>
    </div>
</div>

<!-- Modal Pilih Metode Pembayaran -->
<div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden p-4">
    <div class="bg-white rounded-3xl p-6 sm:p-8 w-full max-w-md">
        <div class="text-center mb-6">
            <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-2">Pilih Metode Pembayaran</h3>
            <div class="text-base sm:text-lg font-bold text-blue-600" id="paymentTotal"></div>
        </div>

        <div class="space-y-3 mb-6">
            @foreach($paymentMethods as $method)
            <button type="button" class="payment-option w-full p-4 border-2 border-gray-200 rounded-xl hover:border-blue-400 hover:bg-blue-50 transition-all duration-200 text-left" 
                    data-method-id="{{ $method->id }}" 
                    data-method-name="{{ $method->name }}"
                    data-method-type="{{ $method->type }}"
                    data-account-number="{{ $method->account_number ?? '' }}"
                    data-account-name="{{ $method->account_name ?? '' }}"
                    data-qris="{{ $method->qris_image ? asset('storage/'.$method->qris_image) : '' }}">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="font-semibold text-gray-800 text-sm sm:text-base">{{ $method->name }}</span>
                        @if($method->type !== 'cash' && ($method->account_number || $method->account_name))
                            <div class="text-xs sm:text-sm text-gray-500">
                                @if($method->account_name)
                                    {{ $method->account_name }}
                                @endif
                                @if($method->account_number)
                                    @if($method->account_name) - @endif
                                    {{ $method->account_number }}
                                @endif
                            </div>
                        @endif
                    </div>
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </button>
            @endforeach
        </div>

        <button type="button" id="backToConfirmation" class="w-full bg-gray-200 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-300 transition-all duration-200 text-sm sm:text-base">
            Kembali
        </button>
    </div>
</div>

<!-- Modal Detail Pembayaran -->
<div id="paymentDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden p-4">
    <div class="bg-white rounded-3xl p-6 sm:p-8 w-full max-w-md max-h-screen overflow-y-auto">
        <div class="text-center mb-6">
            <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-2">Detail Pembayaran</h3>
            <p id="selectedPaymentMethod" class="text-gray-600 mb-2 text-sm sm:text-base"></p>
            <div class="text-base sm:text-lg font-bold text-blue-600" id="transferTotal"></div>
        </div>

        <!-- Bank Transfer Information -->
        <div id="bankInfo" class="space-y-4 mb-6">
            <div class="bg-blue-50 rounded-xl p-4">
                <h4 class="font-semibold text-gray-800 mb-3 flex items-center text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Informasi Transfer
                </h4>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                        <div>
                            <label class="text-xs sm:text-sm font-medium text-gray-600">Nama Pemilik</label>
                            <p id="accountName" class="font-semibold text-gray-800 text-sm sm:text-base">-</p>
                        </div>
                        <button type="button" class="copy-btn p-2 text-blue-600 hover:bg-blue-100 rounded-lg" data-copy="account-name">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                            </svg>
                        </button>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                        <div>
                            <label class="text-xs sm:text-sm font-medium text-gray-600">Nomor Rekening</label>
                            <p id="accountNumber" class="font-semibold text-gray-800 font-mono text-sm sm:text-base">-</p>
                        </div>
                        <button type="button" class="copy-btn p-2 text-blue-600 hover:bg-blue-100 rounded-lg" data-copy="account-number">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                            </svg>
                        </button>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                        <div>
                            <label class="text-xs sm:text-sm font-medium text-gray-600">Jumlah Transfer</label>
                            <p id="transferAmount" class="font-bold text-blue-600 text-base sm:text-lg">Rp 0</p>
                        </div>
                        <button type="button" class="copy-btn p-2 text-blue-600 hover:bg-blue-100 rounded-lg" data-copy="amount">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- QR Code Section -->
            <div id="qrisSection" class="bg-gray-50 rounded-xl p-4 sm:p-6 text-center" style="display: none;">
                <h4 class="font-semibold text-gray-800 mb-4 text-sm sm:text-base">Atau Scan QR Code</h4>
                <img id="qrisImage" src="" alt="QR Code" class="mx-auto max-w-full h-48 sm:h-64 object-contain rounded-lg mb-4 border">
                <p class="text-xs sm:text-sm text-gray-600">Scan QR Code di atas dengan aplikasi e-wallet atau mobile banking Anda</p>
            </div>
        </div>

        <div class="space-y-3">
            <button type="button" id="confirmPayment" class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-emerald-700 transition-all duration-200 text-sm sm:text-base">
                <span class="flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Sudah Transfer
                </span>
            </button>
            <button type="button" id="backToPaymentMethod" class="w-full bg-gray-200 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-300 transition-all duration-200 text-sm sm:text-base">
                Pilih Metode Lain
            </button>
        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Mobile optimizations */
@media (max-width: 640px) {
    body {
        padding-bottom: 0 !important;
    }
    
    /* Ensure mobile fixed bottom bar stays at bottom */
    .fixed.bottom-0 {
        position: fixed !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
    }
    
    /* Add safe area for iOS */
    .fixed.bottom-0 {
        padding-bottom: env(safe-area-inset-bottom, 0px);
    }
    
    /* Better scrolling on mobile */
    .max-h-20 {
        -webkit-overflow-scrolling: touch;
    }
    
    /* Improve touch targets */
    .quantity-btn {
        min-height: 44px;
        min-width: 44px;
    }
    
    /* Better modal positioning on mobile */
    .fixed.inset-0 {
        padding: 1rem;
    }
    
    /* Improve text readability on small screens */
    .text-xs {
        font-size: 0.75rem !important;
        line-height: 1rem !important;
    }
}

/* Tablet optimizations */
@media (min-width: 641px) and (max-width: 1024px) {
    .grid-cols-1.sm\:grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

/* Enhanced hover effects for desktop */
@media (min-width: 1025px) {
    .hover\:scale-105:hover {
        transform: scale(1.05);
    }
    
    .hover\:shadow-xl:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
}

.payment-option.selected {
    border-color: #3b82f6 !important;
    background-color: #dbeafe !important;
}

.copy-btn:hover svg {
    transform: scale(1.1);
}

.copy-btn.copied {
    color: #10b981 !important;
}

/* Smooth transitions for better UX */
* {
    -webkit-tap-highlight-color: transparent;
}

.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}

/* Better focus states for accessibility */
button:focus, input:focus, textarea:focus {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}

/* Gradient button improvements */
.bg-gradient-to-r {
    background-size: 200% 200%;
    animation: gradient 3s ease infinite;
}

@keyframes gradient {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

/* Loading states */
.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

/* Better scrollbar styling */
::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('orderForm');
    const selectedItemsContainer = document.getElementById('selectedItems');
    const orderSummary = document.getElementById('orderSummary');
    const mobileOrderSummary = document.getElementById('mobileOrderSummary');
    const totalAmountEl = document.getElementById('totalAmount');
    const mobileTotal = document.getElementById('mobileTotal');
    const orderBtn = document.getElementById('orderBtn');
    const mobileOrderBtn = document.getElementById('mobileOrderBtn');
    
    // Modals
    const confirmationModal = document.getElementById('confirmationModal');
    const paymentModal = document.getElementById('paymentModal');
    const paymentDetailsModal = document.getElementById('paymentDetailsModal');

    let currentOrderData = {};

    // Filter kategori
    const filterButtons = document.querySelectorAll('.filter-btn');
    const categorySections = document.querySelectorAll('.category-section');
    
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const catId = btn.dataset.category;
            
            // Update button styles
            filterButtons.forEach(b => {
                b.classList.remove('bg-gradient-to-r', 'from-blue-500', 'to-indigo-600', 'text-white');
                b.classList.add('bg-gray-100', 'text-gray-700');
            });
            btn.classList.add('bg-gradient-to-r', 'from-blue-500', 'to-indigo-600', 'text-white');
            btn.classList.remove('bg-gray-100', 'text-gray-700');
            
            // Show/hide categories
            categorySections.forEach(section => {
                if(catId === 'all' || section.dataset.categoryId === catId){
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        });
    });

    // Quantity buttons with better mobile support
    document.querySelectorAll('.quantity-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const action = btn.dataset.action;
            const targetId = btn.dataset.target;
            const input = document.getElementById(targetId);
            let currentValue = parseInt(input.value) || 0;
            const max = parseInt(btn.dataset.max) || parseInt(input.max) || 999;

            if (action === 'plus' && currentValue < max) {
                input.value = currentValue + 1;
                // Add visual feedback
                btn.classList.add('bg-blue-100');
                setTimeout(() => btn.classList.remove('bg-blue-100'), 150);
            } else if (action === 'minus' && currentValue > 0) {
                input.value = currentValue - 1;
                // Add visual feedback
                btn.classList.add('bg-red-100');
                setTimeout(() => btn.classList.remove('bg-red-100'), 150);
            }

            updateOrder();
        });

        // Add touch feedback for mobile
        btn.addEventListener('touchstart', (e) => {
            btn.style.transform = 'scale(0.95)';
        });

        btn.addEventListener('touchend', (e) => {
            setTimeout(() => {
                btn.style.transform = '';
            }, 100);
        });
    });

    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(amount);
    }

    function updateOrder() {
        const quantities = document.querySelectorAll('.menu-quantity');
        let selectedItems = [];
        let total = 0;
        let summaryHTML = '';
        let mobileSummaryHTML = '';

        // Clear existing hidden inputs
        selectedItemsContainer.innerHTML = '';

        quantities.forEach((qtyInput) => {
            const quantity = parseInt(qtyInput.value) || 0;
            if (quantity > 0) {
                const menuId = qtyInput.dataset.menuId;
                const menuName = qtyInput.dataset.menuName;
                const menuPrice = parseFloat(qtyInput.dataset.menuPrice);

                selectedItems.push({
                    menu_id: menuId,
                    quantity: quantity,
                    name: menuName,
                    price: menuPrice,
                    total: quantity * menuPrice
                });

                total += quantity * menuPrice;

                // Add hidden inputs for form submission
                const itemIndex = selectedItems.length - 1;
                selectedItemsContainer.innerHTML += `
                    <input type="hidden" name="items[${itemIndex}][menu_id]" value="${menuId}">
                    <input type="hidden" name="items[${itemIndex}][quantity]" value="${quantity}">
                `;

                // Desktop summary
                summaryHTML += `
                    <div class="flex justify-between items-center bg-gray-50 px-3 py-2 rounded-lg">
                        <span class="text-sm font-medium">${quantity}x ${menuName}</span>
                        <span class="text-sm font-bold text-blue-600">${formatRupiah(quantity * menuPrice)}</span>
                    </div>
                `;

                // Mobile summary (more compact)
                mobileSummaryHTML += `
                    <div class="flex justify-between items-center text-xs">
                        <span class="font-medium text-gray-700">${quantity}x ${menuName}</span>
                        <span class="font-bold text-blue-600">${formatRupiah(quantity * menuPrice)}</span>
                    </div>
                `;
            }
        });

        currentOrderData = { selectedItems, total };

        if (selectedItems.length > 0) {
            orderSummary.innerHTML = summaryHTML;
            mobileOrderSummary.innerHTML = mobileSummaryHTML;
            orderBtn.disabled = false;
            mobileOrderBtn.disabled = false;
        } else {
            orderSummary.innerHTML = '<p class="text-gray-500 text-center py-4">Belum ada item yang dipilih</p>';
            mobileOrderSummary.innerHTML = '<p class="text-gray-500 text-center text-sm py-2">Belum ada item yang dipilih</p>';
            orderBtn.disabled = true;
            mobileOrderBtn.disabled = true;
        }

        const formattedTotal = formatRupiah(total);
        totalAmountEl.innerHTML = `
            <span>Total:</span>
            <span class="text-blue-600">${formattedTotal}</span>
        `;
        mobileTotal.textContent = formattedTotal;
    }

    // Order button clicks - show confirmation modal
    [orderBtn, mobileOrderBtn].forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            showConfirmationModal();
        });
    });

    function showConfirmationModal() {
        const customerName = document.querySelector('input[name="customer_name"]').value;
        const notes = document.querySelector('textarea[name="notes"]').value;
        
        if (!customerName.trim()) {
            alert('Mohon masukkan nama Anda terlebih dahulu');
            document.querySelector('input[name="customer_name"]').focus();
            return;
        }

        // Populate confirmation modal
        document.getElementById('confirmCustomerName').textContent = customerName;
        document.getElementById('confirmTotal').textContent = formatRupiah(currentOrderData.total);
        document.getElementById('paymentTotal').textContent = formatRupiah(currentOrderData.total);
        document.getElementById('transferTotal').textContent = formatRupiah(currentOrderData.total);

        // Show order items
        let itemsHTML = '';
        currentOrderData.selectedItems.forEach(item => {
            itemsHTML += `
                <div class="flex justify-between items-center">
                    <span class="text-sm">${item.quantity}x ${item.name}</span>
                    <span class="text-sm font-semibold text-blue-600">${formatRupiah(item.total)}</span>
                </div>
            `;
        });
        document.getElementById('confirmOrderItems').innerHTML = itemsHTML;

        // Show notes if any
        if (notes.trim()) {
            document.getElementById('confirmNotes').classList.remove('hidden');
            document.getElementById('confirmNotesText').textContent = notes;
        } else {
            document.getElementById('confirmNotes').classList.add('hidden');
        }

        confirmationModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    // Confirmation modal buttons
    document.getElementById('proceedToPayment').addEventListener('click', () => {
        confirmationModal.classList.add('hidden');
        paymentModal.classList.remove('hidden');
    });

    document.getElementById('cancelOrder').addEventListener('click', () => {
        confirmationModal.classList.add('hidden');
        document.body.style.overflow = ''; // Restore scrolling
    });

    document.getElementById('backToConfirmation').addEventListener('click', () => {
        paymentModal.classList.add('hidden');
        confirmationModal.classList.remove('hidden');
    });

    // Payment method selection with better mobile support
    document.querySelectorAll('.payment-option').forEach(option => {
        option.addEventListener('click', (e) => {
            e.preventDefault();
            
            // Add selection visual feedback
            document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
            option.classList.add('selected');
            
            const methodId = option.dataset.methodId;
            const methodName = option.dataset.methodName;
            const methodType = option.dataset.methodType;
            const accountNumber = option.dataset.accountNumber;
            const accountName = option.dataset.accountName;
            const qrisUrl = option.dataset.qris;

            console.log('Payment method selected:', {
                methodId, methodName, methodType, accountNumber, accountName, qrisUrl
            });

            document.getElementById('selectedPaymentMethodId').value = methodId;
            
            if (methodType === 'cash') {
                // For cash payment, directly submit
                if (confirm(`Pembayaran tunai dipilih dengan total ${formatRupiah(currentOrderData.total)}.\n\nPesanan akan diproses dan silakan bayar kepada kasir saat pesanan siap.`)) {
                    submitOrder();
                }
            } else {
                // For non-cash payments, show payment details
                showPaymentDetails(methodName, accountNumber, accountName, qrisUrl);
                paymentModal.classList.add('hidden');
                paymentDetailsModal.classList.remove('hidden');
            }
        });

        // Add touch feedback
        option.addEventListener('touchstart', () => {
            option.style.transform = 'scale(0.98)';
        });

        option.addEventListener('touchend', () => {
            setTimeout(() => {
                option.style.transform = '';
            }, 100);
        });
    });

    function showPaymentDetails(methodName, accountNumber, accountName, qrisUrl) {
        console.log('Showing payment details:', { methodName, accountNumber, accountName, qrisUrl });
        
        // Set payment method info
        document.getElementById('selectedPaymentMethod').textContent = methodName;
        
        // Handle account name
        const accountNameEl = document.getElementById('accountName');
        if (accountName && accountName !== 'undefined' && accountName !== '' && accountName !== 'null') {
            accountNameEl.textContent = accountName;
        } else {
            accountNameEl.textContent = '-';
        }
        
        // Handle account number
        const accountNumberEl = document.getElementById('accountNumber');
        if (accountNumber && accountNumber !== 'undefined' && accountNumber !== '' && accountNumber !== 'null') {
            accountNumberEl.textContent = accountNumber;
        } else {
            accountNumberEl.textContent = '-';
        }
        
        document.getElementById('transferAmount').textContent = formatRupiah(currentOrderData.total);

        // Show/hide QR code section
        const qrisSection = document.getElementById('qrisSection');
        if (qrisUrl && qrisUrl !== '' && qrisUrl !== 'undefined' && qrisUrl !== 'null') {
            document.getElementById('qrisImage').src = qrisUrl;
            document.getElementById('qrisImage').onerror = function() {
                qrisSection.style.display = 'none';
            };
            qrisSection.style.display = 'block';
        } else {
            qrisSection.style.display = 'none';
        }
    }

    // Copy functionality with better mobile feedback
    document.addEventListener('click', function(e) {
        if (e.target.closest('.copy-btn')) {
            const copyBtn = e.target.closest('.copy-btn');
            const copyType = copyBtn.dataset.copy;
            let textToCopy = '';
            
            switch(copyType) {
                case 'account-name':
                    textToCopy = document.getElementById('accountName').textContent;
                    break;
                case 'account-number':
                    textToCopy = document.getElementById('accountNumber').textContent;
                    break;
                case 'amount':
                    textToCopy = currentOrderData.total.toString();
                    break;
            }
            
            if (textToCopy && textToCopy !== '-' && textToCopy !== 'undefined') {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(textToCopy).then(() => {
                        // Show feedback
                        const originalHTML = copyBtn.innerHTML;
                        copyBtn.innerHTML = '<svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
                        copyBtn.classList.add('copied');
                        
                        // Show toast notification for mobile
                        showToast('Berhasil disalin!');
                        
                        setTimeout(() => {
                            copyBtn.innerHTML = originalHTML;
                            copyBtn.classList.remove('copied');
                        }, 2000);
                    }).catch(() => {
                        showToast('Gagal menyalin. Silakan salin manual.');
                    });
                } else {
                    // Fallback for older browsers
                    const textArea = document.createElement('textarea');
                    textArea.value = textToCopy;
                    document.body.appendChild(textArea);
                    textArea.select();
                    try {
                        document.execCommand('copy');
                        showToast('Berhasil disalin!');
                    } catch (err) {
                        showToast('Gagal menyalin. Silakan salin manual.');
                    }
                    document.body.removeChild(textArea);
                }
            }
        }
    });

    // Toast notification function
    function showToast(message) {
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-20 left-4 right-4 sm:left-1/2 sm:right-auto sm:transform sm:-translate-x-1/2 bg-gray-800 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-center text-sm';
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(100%)';
            setTimeout(() => {
                if (document.body.contains(toast)) {
                    document.body.removeChild(toast);
                }
            }, 300);
        }, 2000);
    }

    document.getElementById('backToPaymentMethod').addEventListener('click', () => {
        paymentDetailsModal.classList.add('hidden');
        paymentModal.classList.remove('hidden');
    });

    document.getElementById('confirmPayment').addEventListener('click', () => {
        if (confirm('Apakah Anda yakin sudah melakukan pembayaran?')) {
            submitOrder();
        }
    });

    function submitOrder() {
        // Show loading state
        const submitButtons = document.querySelectorAll('#confirmPayment, #orderBtn, #mobileOrderBtn');
        submitButtons.forEach(btn => {
            btn.innerHTML = `
                <span class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-3 h-4 w-4 sm:h-5 sm:w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses...
                </span>
            `;
            btn.disabled = true;
        });

        form.submit();
    }

    // Close modals when clicking outside or using escape key
    [confirmationModal, paymentModal, paymentDetailsModal].forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            // Close any open modal
            [confirmationModal, paymentModal, paymentDetailsModal].forEach(modal => {
                if (!modal.classList.contains('hidden')) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });
        }
    });

    // Prevent zoom on double tap for iOS
    let lastTouchEnd = 0;
    document.addEventListener('touchend', function (event) {
        const now = (new Date()).getTime();
        if (now - lastTouchEnd <= 300) {
            event.preventDefault();
        }
        lastTouchEnd = now;
    }, false);

    // Initial update
    updateOrder();

    // Add smooth scrolling for better UX
    document.documentElement.style.scrollBehavior = 'smooth';
});
</script>
@endsection