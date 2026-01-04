<!-- resources/views/admin/tables/create.blade.php -->

@extends('admin.layouts.app')

@section('title', 'Add Table')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Add Table</h1>

@if ($errors->any())
<div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.tables.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
        <label class="block text-gray-700">Table Number</label>
        <input type="text" name="table_number" value="{{ old('table_number') }}" class="border px-3 py-2 rounded w-full">
    </div>
    <div>
        <label class="block text-gray-700">Capacity</label>
        <input type="number" name="capacity" value="{{ old('capacity',1) }}" min="1" class="border px-3 py-2 rounded w-full">
    </div>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create Table</button>
</form>
@endsection
