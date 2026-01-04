@extends('admin.layouts.app')

@section('title', 'Pesanan #' . str_pad($order->id, 4, '0', STR_PAD_LEFT))

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.orders.index') }}" class="hover:text-gray-700">Pesanan</a>
                <span>/</span>
                <span class="text-gray-900">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900">Detail Pesanan</h1>
            <p class="text-gray-600 mt-1">Kelola dan lacak status pesanan</p>
        </div>
        
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.orders.index') }}" 
               class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                ← Kembali ke Daftar Pesanan
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
        <p class="text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Pesanan</h3>
                
                @if($order->status !== 'completed' && $order->status !== 'cancelled')
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Pesanan</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Sedang Disiapkan</option>
                                <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Siap Diambil</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Pembayaran</label>
                            <select name="payment_status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                @if($order->payment_status === 'paid') disabled @endif>
                                <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Dibayar</option>
                                <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Gagal</option>
                                <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Dikembalikan</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            Perbarui Pesanan
                        </button>
                    </div>
                </form>
                @else
                <p class="text-sm text-gray-500 text-center py-4">Status pesanan ini tidak dapat diubah lagi.</p>
                @endif

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">ID Pesanan</span>
                            <span class="text-sm font-medium">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Nomor Pesanan</span>
                            <span class="text-sm font-medium">{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Pelanggan</span>
                            <span class="text-sm font-medium">{{ $order->customer_name ?? 'Tamu' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Meja</span>
<span class="text-sm text-gray-900">{{ $order->table->name ?? $order->table->table_number ?? 'Tidak Ada Meja' }}</span>                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Metode Pembayaran</span>
                            <span class="text-sm font-medium">{{ $order->paymentMethod->name ?? 'Belum Dipilih' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Status Pembayaran</span>
                            <span class="text-sm font-medium capitalize
                                {{ $order->payment_status === 'paid' ? 'text-green-600' : ($order->payment_status === 'pending' ? 'text-yellow-600' : ($order->payment_status === 'unpaid' ? 'text-red-600' : ($order->payment_status === 'failed' ? 'text-red-600' : 'text-gray-600'))) }}">
                                {{ $order->payment_status }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Waktu Pesanan</span>
                            <span class="text-sm font-medium">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total</span>
                            <span class="text-lg font-bold text-green-600">Rp{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                @if($order->status !== 'completed' && $order->status !== 'cancelled')
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Aksi Cepat</h4>
                    <div class="space-y-2">
                        @if($order->payment_status !== 'paid')
                        <form action="{{ route('admin.orders.quick-action', $order) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="mark_paid">
                            <button type="submit" class="w-full px-3 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                Tandai Sudah Dibayar
                            </button>
                        </form>
                        @endif

                        @if($order->status === 'preparing')
                        <form action="{{ route('admin.orders.quick-action', $order) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="mark_ready">
                            <button type="submit" class="w-full px-3 py-2 text-sm bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                                Tandai Siap Diambil
                            </button>
                        </form>
                        @endif

                        @if($order->status === 'ready' || ($order->status === 'confirmed' && $order->payment_status === 'paid'))
                        <form action="{{ route('admin.orders.quick-action', $order) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="complete_order">
                            <button type="submit" class="w-full px-3 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Selesaikan Pesanan
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Item Pesanan</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($order->orderItems as $item)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">{{ $item->menu->name }}</h4>
                                <div class="flex items-center space-x-4 mt-1 text-sm text-gray-600">
                                    <span>Jumlah: {{ $item->quantity }}</span>
                                    <span>Harga Satuan: Rp{{ number_format($item->unit_price, 2) }}</span>
                                </div>
                                @if($item->notes)
                                <div class="mt-2 p-2 bg-blue-50 rounded border border-blue-200">
                                    <div class="flex items-start">
                                        <svg class="w-4 h-4 mr-1 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        <span class="text-blue-800 text-sm">{{ $item->notes }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-gray-900">Rp{{ number_format($item->total_price, 2) }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @if($order->notes)
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Catatan Khusus
                </h3>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="text-yellow-800">{{ $order->notes }}</p>
                </div>
            </div>
            @endif

            @if($order->transaction)
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Transaksi</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-sm text-gray-600">ID Transaksi</span>
                        <p class="font-medium">#{{ str_pad($order->transaction->id, 4, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Jumlah</span>
                        <p class="font-medium text-green-600">Rp{{ number_format($order->transaction->amount, 2) }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Status</span>
                        <p class="font-medium capitalize
                            {{ $order->transaction->status === 'completed' ? 'text-green-600' : ($order->transaction->status === 'pending' ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ $order->transaction->status }}
                        </p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Dibuat Pada</span>
                        <p class="font-medium">{{ $order->transaction->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection