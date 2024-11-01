<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalhes do Decreto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Informações sobre o decreto --}}
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <h3 class="text-lg font-medium">Número</h3>
                            <p class="text-gray-600">{{ $decree->number }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium">DOE</h3>
                            <p class="text-gray-600">{{ $decree->doe_number }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium">Data de Publicação</h3>
                            <p class="text-gray-600">{{ \Carbon\Carbon::parse($decree->effective_date)->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium">Ementa</h3>
                            <p class="text-gray-600 break-words">{{ $decree->summary }}</p>
                        </div>
                    </div>

                    {{-- Botão para abrir o modal --}}
                    <div class="mt-6">
                        <a href="#" onclick="toggleModal()" class="px-4 py-2 bg-green-600 text-white rounded">
                            Ver Conteúdo
                        </a>
                        <a href="{{ route('decrees.edit', $decree->id) }}" class="ml-4 px-4 py-2 bg-blue-600 text-white rounded">
                            Editar Decreto
                        </a>
                        <a href="{{ route('decrees.index') }}" class="ml-4 px-4 py-2 bg-gray-600 text-white rounded">Voltar</a>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para exibir o conteúdo --}}
    <div id="contentModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            {{-- Fundo escuro para clicar fora e fechar o modal --}}
            <div onclick="toggleModal()" class="fixed inset-0 bg-gray-500 opacity-75"></div>
            
            {{-- Conteúdo do modal ampliado --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-4xl w-full h-3/4 p-6 relative z-20 overflow-y-auto">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium">Conteúdo do Decreto</h3>
                    <button onclick="toggleModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 font-bold text-xl">
                        &times;
                    </button>
                </div>
                <div class="mt-4 text-gray-600 whitespace-pre-line">
                    {{ $decree->content }}
                </div>
            </div>
        </div>
    </div>


    {{-- Script JavaScript para alternar o modal --}}
    <script>
        function toggleModal() {
            const modal = document.getElementById('contentModal');
            modal.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
