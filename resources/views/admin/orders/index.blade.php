@extends('admin.layouts.app')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manajemen Pesanan</h1>
            <p class="text-gray-600 mt-1">Kelola dan lacak semua pesanan restoran</p>
        </div>
        
        <!-- Pagination Info -->
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <span>Menampilkan</span>
            <span class="font-medium text-gray-900">{{ $orders->firstItem() ?? 0 }}</span>
            <span>-</span>
            <span class="font-medium text-gray-900">{{ $orders->lastItem() ?? 0 }}</span>
            <span>dari</span>
            <span class="font-medium text-gray-900">{{ $orders->total() }}</span>
            <span>pesanan</span>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <p class="ml-3 text-sm text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <div class="bg-white shadow-sm border border-gray-200 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Pesanan</h3>
        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-700">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <option value="">Semua Status</option>
                    @foreach(['pending' => 'Menunggu', 'confirmed' => 'Dikonfirmasi', 'preparing' => 'Disiapkan', 'ready' => 'Siap', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $value => $label)
                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-700">Status Pembayaran</label>
                <select name="payment_status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <option value="">Semua Status Pembayaran</option>
                    @foreach(['pending' => 'Menunggu', 'unpaid' => 'Belum Dibayar', 'paid' => 'Dibayar', 'failed' => 'Gagal', 'refunded' => 'Dikembalikan'] as $value => $label)
                    <option value="{{ $value }}" {{ request('payment_status') == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-700">Meja</label>
                <select name="table" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <option value="">Semua Meja</option>
                    @foreach($tables as $table)
                    <option value="{{ $table->id }}" {{ request('table') == $table->id ? 'selected' : '' }}>
                        {{ $table->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-700">Tanggal Dari</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>
            
            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-700">Tanggal Sampai</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>
            
            <div class="flex items-end lg:col-span-5">
                <div class="flex space-x-2 w-full lg:w-auto">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-500 text-white font-medium rounded-lg hover:bg-gray-600 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all">
                        Reset Filter
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Pesanan</h3>
            <div class="text-sm text-gray-600">
                Halaman {{ $orders->currentPage() }} dari {{ $orders->lastPage() }}
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID Pesanan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Meja</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pembayaran</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900">{{ $order->customer_name ?? 'Tamu' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-900">{{ $order->table->name ?? $order->table->table_number ?? 'Tidak Ada Meja' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($order->status === 'pending') 
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full mr-1.5"></span>
                                    Menunggu
                                </span>
                            @elseif($order->status === 'confirmed') 
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <span class="w-1.5 h-1.5 bg-blue-400 rounded-full mr-1.5"></span>
                                    Dikonfirmasi
                                </span>
                            @elseif($order->status === 'preparing') 
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                    <span class="w-1.5 h-1.5 bg-orange-400 rounded-full mr-1.5"></span>
                                    Disiapkan
                                </span>
                            @elseif($order->status === 'ready') 
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    <span class="w-1.5 h-1.5 bg-purple-400 rounded-full mr-1.5"></span>
                                    Siap
                                </span>
                            @elseif($order->status === 'completed') 
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></span>
                                    Selesai
                                </span>
                            @elseif($order->status === 'cancelled') 
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <span class="w-1.5 h-1.5 bg-red-400 rounded-full mr-1.5"></span>
                                    Dibatalkan
                                </span>
                            @else 
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1.5"></span>
                                    {{ ucfirst($order->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($order->payment_status === 'pending') 
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full mr-1.5"></span>
                                    Menunggu
                                </span>
                            @elseif($order->payment_status === 'unpaid') 
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <span class="w-1.5 h-1.5 bg-red-400 rounded-full mr-1.5"></span>
                                    Belum Dibayar
                                </span>
                            @elseif($order->payment_status === 'paid') 
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></span>
                                    Dibayar
                                </span>
                            @elseif($order->payment_status === 'failed') 
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <span class="w-1.5 h-1.5 bg-red-400 rounded-full mr-1.5"></span>
                                    Gagal
                                </span>
                            @elseif($order->payment_status === 'refunded') 
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1.5"></span>
                                    Dikembalikan
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-semibold text-gray-900">Rp {{ number_format($order->total_amount, 2, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.orders.show', $order) }}" 
                                   class="inline-flex items-center px-2 py-1 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 transition-all">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Lihat
                                </a>

                                <!-- Print Receipt Button -->
                                <button onclick="printReceipt({{ $order->id }})" 
                                        class="inline-flex items-center px-2 py-1 bg-gray-600 text-white text-xs font-medium rounded hover:bg-gray-700 transition-all">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                    </svg>
                                    Struk
                                </button>
                                
                                @if($order->payment_status !== 'paid' && $order->status !== 'cancelled')
                                <form action="{{ route('admin.orders.quick-action', $order) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="action" value="mark_paid">
                                    <button type="submit" 
                                            class="inline-flex items-center px-2 py-1 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 transition-all">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        Bayar
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-gray-500 text-lg font-medium">Tidak ada pesanan ditemukan</p>
                                <p class="text-gray-400 text-sm">Pesanan akan muncul di sini saat pelanggan membuatnya</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Enhanced Pagination Section -->
    @if($orders->hasPages())
    <div class="bg-white border border-gray-200 rounded-xl">
        <div class="px-6 py-3 flex items-center justify-between border-b border-gray-200">
            <div class="flex-1 flex justify-between sm:hidden">
                <!-- Mobile pagination -->
                @if($orders->onFirstPage())
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                        Sebelumnya
                    </span>
                @else
                    <a href="{{ $orders->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-blue-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                        Sebelumnya
                    </a>
                @endif

                @if($orders->hasMorePages())
                    <a href="{{ $orders->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-blue-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                        Selanjutnya
                    </a>
                @else
                    <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                        Selanjutnya
                    </span>
                @endif
            </div>

            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700 leading-5">
                        Menampilkan
                        <span class="font-medium">{{ $orders->firstItem() ?? 0 }}</span>
                        sampai
                        <span class="font-medium">{{ $orders->lastItem() ?? 0 }}</span>
                        dari
                        <span class="font-medium">{{ $orders->total() }}</span>
                        pesanan
                    </p>
                </div>

                <div>
                    <span class="relative z-0 inline-flex shadow-sm rounded-md">
                        {{-- Previous Page Link --}}
                        @if($orders->onFirstPage())
                            <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                        @else
                            <a href="{{ $orders->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-blue-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                            @if($page == $orders->currentPage())
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white bg-blue-600 border border-blue-600 cursor-default leading-5">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-blue-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-blue-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick navigation -->
        <div class="px-6 py-3 bg-gray-50">
            <div class="flex items-center justify-between text-sm text-gray-600">
                <div class="flex items-center space-x-2">
                    <span>Lompat ke halaman:</span>
                    <select onchange="window.location.href=this.value" class="px-2 py-1 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @for($i = 1; $i <= $orders->lastPage(); $i++)
                            <option value="{{ $orders->url($i) }}" {{ $orders->currentPage() == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                
                <div class="flex items-center space-x-4">
                    @if($orders->currentPage() > 1)
                        <a href="{{ $orders->url(1) }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                            Halaman Pertama
                        </a>
                    @endif
                    
                    @if($orders->currentPage() < $orders->lastPage())
                        <a href="{{ $orders->url($orders->lastPage()) }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                            Halaman Terakhir
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
function printReceipt(orderId) {
    fetch(`/admin/orders/${orderId}/receipt-data`)
        .then(response => response.json())
        .then(order => {
            const receiptHtml = generateReceiptHtml(order);
            
            const receiptWindow = window.open('', '_blank', 'width=220,height=400,scrollbars=no,resizable=no');
            
            receiptWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="utf-8">
                    <title>Struk #${order.id}</title>
                    <style>
                        @page {
                            size: 58mm auto;
                            margin: 0;
                        }
                        body { 
                            font-family: 'Courier New', monospace; 
                            font-size: 8px; 
                            margin: 0; 
                            padding: 2mm;
                            width: 54mm;
                            background: white;
                            color: black;
                            line-height: 1.2;
                        }
                        .center { text-align: center; }
                        .bold { font-weight: bold; }
                        .line { border-top: 1px dashed black; margin: 1mm 0; }
                        .row { display: flex; justify-content: space-between; margin: 0; }
                        .item { margin: 1px 0; }
                        .header { font-size: 10px; margin-bottom: 2mm; }
                        .total-section { margin-top: 2mm; }
                        .footer { margin-top: 2mm; font-size: 7px; }
                    </style>
                </head>
                <body onload="setTimeout(function(){window.print();}, 100);">
                    ${receiptHtml}
                </body>
                </html>
            `);
            
            receiptWindow.document.close();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memuat data struk');
        });
}

function generateReceiptHtml(order) {
    const items = order.order_items || [];
    const total = parseFloat(order.total_amount || 0);
    
    let itemsHtml = '';
    items.forEach(item => {
        const itemName = item.menu ? item.menu.name : 'Item';
        const itemPrice = parseFloat(item.total_price || 0);
        
        itemsHtml += `<div class="item">
<div class="row">
<span>${item.quantity}x ${itemName.length > 20 ? itemName.substring(0, 20) : itemName}</span>
<span>${numberFormat(itemPrice)}</span>
</div>
</div>`;
    });

    const now = new Date();
    const dateStr = now.getDate().toString().padStart(2, '0') + '/' + 
                   (now.getMonth() + 1).toString().padStart(2, '0') + '/' + 
                   now.getFullYear();
    const timeStr = now.getHours().toString().padStart(2, '0') + ':' + 
                   now.getMinutes().toString().padStart(2, '0');

    return `<div class="center header">
<div class="bold">EHF RESTO</div>
<div>Jl. Contoh No.123, Bandung</div>
<div>Tel: (022) 1234567</div>
</div>
<div class="line"></div>
<div class="center">
<div class="bold">STRUK PESANAN</div>
<div>#${order.id.toString().padStart(4, '0')}</div>
</div>
<div class="line"></div>
<div>
<div class="row">
<span>Pelanggan:</span>
<span>${(order.customer_name || 'Tamu').substring(0, 15)}</span>
</div>
<div class="row">
<span>Meja:</span>
<span>${order.table ? order.table.table_number : '-'}</span>
</div>
<div class="row">
<span>Tanggal:</span>
<span>${dateStr}</span>
</div>
<div class="row">
<span>Waktu:</span>
<span>${timeStr}</span>
</div>
</div>
<div class="line"></div>
${itemsHtml}
<div class="line"></div>
<div class="total-section">
<div class="row bold">
<span>TOTAL:</span>
<span>Rp ${numberFormat(total)}</span>
</div>
</div>
<div class="line"></div>
<div class="center footer">
<div>Terima Kasih</div>
<div>Selamat Menikmati</div>
</div>`;
}

function numberFormat(number) {
    return Math.round(number).toLocaleString('id-ID');
}
</script>
@endsection