<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans antialiased h-screen flex">

    <!-- Sidebar -->
    <div class="w-64 h-full bg-gray-800 text-white flex flex-col">
        <div class="py-4 px-6">
            <h1 class="text-2xl font-bold">Admin</h1>
        </div>

        <nav class="flex-1 px-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="flex items-center p-2 rounded-md hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9 6 9-6-9-6-9 6z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10l-9 6-9-6"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 17l-9 6-9-6"></path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('decrees.index') }}" class="flex items-center p-2 rounded-md hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6m2 4h.01M4 4h16v16H4V4z"></path>
                </svg>
                Decretos
            </a>

            <a href="#" class="flex items-center p-2 rounded-md hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A7.968 7.968 0 0112 15a7.968 7.968 0 016.879 2.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Usuários
            </a>
        </nav>

        <div class="py-4 px-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full p-2 text-left rounded-md hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"></path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100 overflow-auto">
        <header class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-semibold text-gray-700">Dashboard</h1>
            <p class="text-sm text-gray-500">Bem-vindo, {{ Auth::user()->name }}!</p>
        </header>

        <!-- Page content -->
        <div>
            @yield('content')
        </div>
    </div>

</body>
</html>
