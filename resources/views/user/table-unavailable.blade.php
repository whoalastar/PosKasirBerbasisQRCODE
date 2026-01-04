@extends('user.layouts.app')

@section('title', 'Table Unavailable - Restaurant')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="text-center space-y-8 max-w-2xl mx-auto">
        <!-- Error Icon -->
        <div class="inline-flex items-center justify-center w-24 h-24 bg-red-100 rounded-full mb-6">
            <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
        </div>

        <!-- Error Message -->
        <div class="space-y-4">
            <h1 class="text-4xl font-bold text-red-600">
                Table #{{ $table->table_number }} is Unavailable
            </h1>
            
            <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                <p class="text-red-800 text-lg">
                    Sorry, this table is currently not available for orders.
                </p>
                <p class="text-red-700 mt-2">
                    This could be due to maintenance, cleaning, or the table being reserved.
                </p>
            </div>
        </div>

        <!-- Solutions -->
        <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center justify-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                What You Can Do
            </h3>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="text-center p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg mb-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-blue-900 mb-2">Ask Our Staff</h4>
                    <p class="text-blue-700 text-sm">
                        Please approach our staff members for assistance with seating arrangements
                    </p>
                </div>

                <div class="text-center p-4 bg-green-50 rounded-lg border border-green-200">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg mb-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15M4.582 9H4m0 0v11a2 2 0 002 2h12a2 2 0 002-2v-11"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-green-900 mb-2">Try Another Table</h4>
                    <p class="text-green-700 text-sm">
                        Look for available tables with accessible QR codes to place your order
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center px-8 py-4 bg-gray-600 text-white font-medium rounded-xl hover:bg-gray-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Back to Home
            </a>
            
            <button onclick="window.location.reload()" 
                    class="inline-flex items-center px-8 py-4 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15M4.582 9H4"></path>
                </svg>
                Try Again
            </button>
        </div>

        <!-- Additional Help -->
        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-center text-gray-600">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm">
                    Need immediate assistance? Please wave to any of our staff members
                </span>
            </div>
        </div>
    </div>
</div>
@endsection