<aside :class="{ '-translate-x-full': !open }"
    class="fixed inset-y-0 left-0 z-50 w-64 transform bg-white shadow-lg lg:translate-x-0 lg:static lg:inset-0 lg:flex lg:flex-col transition-transform duration-300 ease-in-out">

    <div class="flex items-center justify-between p-4">
        <!-- Logo -->
        <h1 class="text-2xl font-bold text-blue-800">Legislação</h1>
        <!-- Close Button para Mobile -->
        <button @click="open = false" class="text-gray-600 hover:text-gray-900 lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="flex-1 px-4 py-4 space-y-4">
        <a href="#" class="flex items-center px-4 py-2 text-gray-700 rounded hover:bg-gray-100 
        {{ request()->routeIs('dashboard') ? 'bg-gray-200 text-gray-900' : '' }}">
        <span class="mr-2 text-blue-800"><i class="fa-solid fa-landmark"></i></span>
            Dashboard
        </a>
        
        <a href="{{ route('decrees.index') }}" class="flex items-center px-4 py-2 text-gray-700 rounded hover:bg-gray-100
        {{ request()->routeIs('decrees') ? 'bg-gray-200 text-gray-900' : '' }}">
          <span class="mr-2 text-blue-800"><i class="fa-solid fa-file-lines"></i></span>
            Decretos
        </a>
    </nav>

    <div class="p-4 border-t border-gray-200">
        <a href="#" class="flex items-center text-gray-600">
          <span class="mr-2 text-blue-800">
            <i class="fa-solid fa-gear"></i>
          </span>
            Settings
        </a>
    </div>
</aside>
