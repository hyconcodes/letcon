<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Forbidden</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col items-center justify-center">
        <!-- Logo -->
        <div class="mb-8">
            <img src="{{ asset('logo.png') }}" alt="Site Logo" class="w-48">
        </div>

        <!-- Error Content -->
        <div class="text-center">
            <h1 class="text-6xl font-bold text-red-600 mb-4">403</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Access Forbidden</h2>
            <p class="text-gray-600 mb-8">Sorry, you don't have permission to access this page.</p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4 w-full px-4 sm:px-0 sm:w-auto">
            <a href="{{ route('home') }}" 
               class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-center">
                Home
            </a>
            <a href="{{ url()->previous() }}" 
               class="w-full sm:w-auto px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-center">
                Go Back
            </a>
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="w-full sm:w-auto px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-center">
                Logout
            </a>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</body>
</html>
