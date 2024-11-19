{{-- resources/views/decrees/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista de Decretos') }}
        </h2>
    </x-slot>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 text-gray-900 dark:text-gray-100 flex">
                    <!-- Botão para criar um novo decreto -->
                    <a href="{{ route('decrees.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                        Novo Decreto
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-2 pb-40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Verifica se há uma mensagem de sucesso na sessão e a exibe --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 sm:rounded-lg mb-4 shadow">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg shadow-md">
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th scope="col" style="min-width: 10em" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    <a href="{{ route('decrees.index', ['sort' => 'number', 'direction' => $sort === 'number' && $direction === 'asc' ? 'desc' : 'asc']) }}">
                                        Número
                                        @if ($sort === 'number')
                                            <span>{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" style="min-width: 10em" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    <a href="{{ route('decrees.index', ['sort' => 'doe_number', 'direction' => $sort === 'doe_number' && $direction === 'asc' ? 'desc' : 'asc']) }}">
                                        DOE
                                        @if ($sort === 'doe_number')
                                            <span>{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    <a href="{{ route('decrees.index', ['sort' => 'effective_date', 'direction' => $sort === 'effective_date' && $direction === 'asc' ? 'desc' : 'asc']) }}">
                                        Data do Documento
                                        @if ($sort === 'effective_date')
                                            <span>{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    <a href="{{ route('decrees.index', ['sort' => 'summary', 'direction' => $sort === 'summary' && $direction === 'asc' ? 'desc' : 'asc']) }}">
                                        Ementa
                                        @if ($sort === 'summary')
                                            <span>{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="hidden lg:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    <a href="{{ route('decrees.index', ['sort' => 'created_at', 'direction' => $sort === 'created_at' && $direction === 'asc' ? 'desc' : 'asc']) }}">
                                        Data de Cadastro
                                        @if ($sort === 'created_at')
                                            <span>{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Ações</span>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($decrees as $decree)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        <a href="{{ route('decrees.edit', $decree->id) }}" class="text-blue-500 hover:underline">{{ $decree->number }}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $decree->doe_number }} 
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ \Carbon\Carbon::parse($decree->effective_date)->format('d/m/Y') }} {{-- Data de Publicação --}}
                                    </td>
                                    <td class="hidden md:table-cell  px-6 py-4 text-sm text-gray-900 dark:text-gray-100 break-words">
                                        {{ $decree->summary }}
                                    </td>
                                    <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ \Carbon\Carbon::parse($decree->created_at)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('decrees.show', $decree->id) }}" class="text-blue-500 hover:underline">Ver</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('decrees.edit', $decree->id) }}" class="text-blue-500 hover:underline">Editar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $decrees->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
