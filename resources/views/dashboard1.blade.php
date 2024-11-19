<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Admin Layout</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <div x-data="{ open: false, openDropdown: false }" class="flex h-screen">

    <!-- Overlay para fechar o menu clicando fora -->
    <div 
      x-show="open" 
      @click="open = false" 
      class="fixed inset-0 bg-gray-900 bg-opacity-50 lg:hidden z-40"
      x-transition.opacity>
    </div>

    <!-- Sidebar -->
    <aside 
      :class="{ '-translate-x-full': !open }" 
      class="fixed inset-y-0 left-0 z-50 w-64 transform bg-white shadow-lg lg:translate-x-0 lg:static lg:inset-0 lg:flex lg:flex-col transition-transform duration-300 ease-in-out">

      <div class="flex items-center justify-between p-4">
        <!-- Logo -->
        <h1 class="text-2xl font-bold text-blue-500">My System</h1>
        <!-- Close Button para Mobile -->
        <button @click="open = false" class="text-gray-600 hover:text-gray-900 lg:hidden">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <nav class="flex-1 px-4 py-4 space-y-4">
        <a href="#" class="flex items-center px-4 py-2 text-gray-700 rounded hover:bg-gray-100">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-7 5h7" />
          </svg>
          Dashboard
        </a>
        <!-- Adicione mais itens de menu conforme necessário -->
        <a href="#" class="flex items-center px-4 py-2 text-gray-700 rounded hover:bg-gray-100">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" />
          </svg>
          Logout
        </a>
      </nav>

      <div class="p-4 border-t border-gray-200">
        <a href="#" class="flex items-center text-gray-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 text-gray-500" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 12c2.208 0 4-1.792 4-4s-1.792-4-4-4-4 1.792-4 4 1.792 4 4 4zM2 22c0-2 4-4 10-4s10 2 10 4v2h-20v-2z" />
          </svg>
          Settings
        </a>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
      <!-- Header -->
      <header class="flex items-center justify-between p-4 bg-white shadow-md lg:px-8">
        <!-- Toggle Button para abrir o Sidebar em Mobile -->
        <button @click="open = !open" class="text-gray-500 focus:outline-none lg:hidden">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
          </svg>
        </button>
        <h1 class="text-lg font-semibold">Dashboard</h1>
        <!-- User Menu Dropdown -->
        <div class="relative">
          <button @click="openDropdown = !openDropdown" class="flex items-center focus:outline-none rounded-full bg-slate-200 p-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A7 7 0 0112 15a7 7 0 016.879 2.804M12 11a4 4 0 100-8 4 4 0 000 8z" />
              </svg>
          </button>
          <div 
            x-show="openDropdown" 
            @click.away="openDropdown = false" 
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
