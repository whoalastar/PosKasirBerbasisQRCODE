<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Login')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md">
        <!-- Optional Header -->
        @hasSection('header')
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">@yield('header')</h1>
        @endif

        <!-- Flash / Error Messages -->
        @yield('messages')

        <!-- Main Content -->
        <div class="bg-white p-8 rounded-lg shadow-lg">
            @yield('content')
        </div>
    </div>

</body>
</html>
