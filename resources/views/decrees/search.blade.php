<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buscar Decretos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Formulário de Busca e Filtros --}}
            <form method="GET" action="{{ route('decrees.search') }}" class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 mb-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número</label>
                        <input type="text" name="number" value="{{ request('number') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">DOE</label>
                        <input type="text" name="doe_number" value="{{ request('doe_number') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data do Documento</label>
                        <input type="date" name="effective_date" value="{{ request('effective_date') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ementa</label>
                        <input type="text" name="summary" value="{{ request('summary') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data de Cadastro</label>
                        <input type="date" name="created_at" value="{{ request('created_at') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ordenar por</label>
                        <select name="sort_by" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <option value="number" {{ request('sort_by') == 'number' ? 'selected' : '' }}>Número</option>
                            <option value="doe_number" {{ request('sort_by') == 'doe_number' ? 'selected' : '' }}>DOE</option>
                            <option value="effective_date" {{ request('sort_by') == 'effective_date' ? 'selected' : '' }}>Data do Documento</option>
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Data de Cadastro</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ordem</label>
                        <select name="sort_order" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descendente</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Buscar</button>
                    <a href="{{ route('decrees.search') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md">Limpar</a>
                </div>
            </form>

            {{-- Tabela de Resultados --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Número</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">DOE</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Data do Documento</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ementa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Data de Cadastro</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ação</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                        @foreach($decrees as $decree)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $decree->number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $decree->doe_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $decree->effective_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 break-words">{{ $decree->summary }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $decree->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('decrees.show', $decree->number) }}" class="text-blue-500 hover:underline">Ver</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginação --}}
            <div class="mt-4">
                {{ $decrees->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
