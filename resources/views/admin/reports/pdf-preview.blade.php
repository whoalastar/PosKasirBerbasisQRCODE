<!-- resources/views/admin/reports/pdf-preview.blade.php -->

@extends('admin.layouts.app')

@section('title', 'PDF Preview')

@section('content')
<h1 class="text-2xl font-semibold mb-4">PDF Preview</h1>

<iframe src="{{ route('admin.reports.export-pdf', ['date_from'=>$dateFrom,'date_to'=>$dateTo]) }}" class="w-full h-screen border" frameborder="0"></iframe>
@endsection
