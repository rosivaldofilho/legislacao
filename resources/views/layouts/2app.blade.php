<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Admin Layout</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-100">

    <div x-data="{ open: false, openDropdown: false }" class="flex h-screen">

        <!-- Overlay para fechar o menu clicando fora -->
        <div x-show="open" @click="open = false" class="fixed inset-0 bg-gray-900 bg-opacity-50 lg:hidden z-40"
            x-transition.opacity>
        </div>

        <!-- Sidebar -->
        @include('layouts.nav_sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="flex items-center justify-between p-4 bg-white shadow-md lg:px-8">

                <!-- Toggle Button para abrir o Sidebar em Mobile -->
                <button @click="open = !open" class="text-gray-500 focus:outline-none lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>

                <!-- Page Heading -->
                @isset($header)
                    <div class="max-w-7xl px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                @endisset

                <!-- User Menu Dropdown -->
                <div class="relative">
                    <button @click="openDropdown = !openDropdown"
                        class="flex items-center focus:outline-none rounded-full bg-slate-200 p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A7 7 0 0112 15a7 7 0 016.879 2.804M12 11a4 4 0 100-8 4 4 0 000 8z" />
                        </svg>
                    </button>
                    <div x-show="openDropdown" @click.away="openDropdown = false"
                        class="absolute right-0 mt-2 w-48 py-2 bg-white border rounded-md shadow-xl"
                        x-transition.origin.top.right>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-4 bg-gray-100 lg:px-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>
