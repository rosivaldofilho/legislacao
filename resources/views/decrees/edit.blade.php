{{-- resources/views/decrees/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Decreto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('decrees.update', $decree->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número</label>
                                <input type="text" name="number" id="number" value="{{ old('number', $decree->number) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:text-gray-100" placeholder="Digite o número do decreto">
                                @error('number')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="doe_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">DOE</label>
                                <input type="text" name="doe_number" id="doe_number" value="{{ old('doe_number', $decree->doe_number) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:text-gray-100" placeholder="Digite o número do DOE">
                                @error('doe_number')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="effective_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data de Publicação</label>
                                <input type="date" name="effective_date" id="effective_date" value="{{ old('effective_date', $decree->effective_date->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:text-gray-100">
                                @error('effective_date')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="file_pdf" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Arquivo PDF (opcional)</label>
                                <input type="file" name="file_pdf" id="file_pdf" accept=".pdf" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:text-gray-100">
                                @error('file_pdf')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="summary" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ementa</label>
                                <textarea name="summary" id="summary" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:text-gray-100" placeholder="Digite a ementa do decreto">{{ old('summary', $decree->summary) }}</textarea>
                                @error('summary')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Conteúdo</label>
                                <textarea name="content" id="content" rows="8" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:text-gray-100" placeholder="Digite o conteúdo do decreto">{{ old('content', $decree->content) }}</textarea>
                                @error('content')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
