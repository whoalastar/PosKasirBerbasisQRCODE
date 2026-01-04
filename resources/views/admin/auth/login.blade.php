@extends('admin.auth.layouts.app')

@section('title', 'Admin Login EHF Creative')
@section('header', 'ADMIN LOGIN EHF CREATIVE.')

@section('messages')
@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
@endsection

@section('content')
<form action="{{ route('admin.login') }}" method="POST" class="space-y-5">
    @csrf

    <!-- Email -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-150">
        @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" name="password" id="password" required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-150">
        @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Remember Me & Forgot Password -->
    <div class="flex items-center justify-between text-sm">
        <label class="inline-flex items-center">
            <input type="checkbox" name="remember" class="form-checkbox h-4 w-4 text-blue-600 rounded">
            <span class="ml-2 text-gray-600">Remember me</span>
        </label>
        <a href="#" class="text-blue-600 hover:underline">Forgot password?</a>
    </div>

    <!-- Submit Button -->
    <button type="submit"
        class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition duration-200">
        Login
    </button>
</form>
@endsection
