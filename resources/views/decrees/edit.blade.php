{{-- resources/views/decrees/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Decreto') }}
        </h2>
    </x-slot>
    <form action="{{ route('decrees.update', $decree->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="pt-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 text-gray-900 dark:text-gray-100 flex justify-between">
                        <div>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                Salvar
                            </button>

                            <a href="{{ route('decrees.index') }}"
                                class="ml-4 inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase  tracking-widest hover:bg-gray-500 active:bg-gray-600 focus:outline-none focus:border-gray-700 focus:ring focus:ring-gray-200 disabled:opacity-25 transition">Cancelar</a>
                        </div>
                        <a href="{{ route('decrees.show', $decree->number) }}"
                            class="ml-4 px-4 py-2 bg-green-600 text-white rounded-md text-xs"><i class="fa-solid fa-search"></i>
                            Ver</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-2">
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


                        <div class="grid grid-cols-1 gap-6">

                            <!-- NÚMERO -->
                            <div>
                                <label for="number"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número</label>
                                <input type="text" name="number" id="number"
                                    value="{{ old('number', $decree->number) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:text-gray-100"
                                    placeholder="Digite o número do decreto">
                                @error('number')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- END NÚMERO -->

                            <!-- DOE -->
                            <div>
                                <label for="doe_numbers" class="block text-sm font-medium text-gray-700">Publicações no DOE</label>
                                <div id="doe_numbers_container">
                                    @foreach ($decree->doe_numbers as $number)
                                        <div class="flex items-center space-x-2 mt-1">
                                            <input type="text" name="doe_numbers[]" value="{{ $number }}" required="true"
                                                   class="block w-full rounded-md border-gray-300 shadow-sm">
                                            <button type="button" 
                                                    class="remove-button text-red-500 font-bold hover:text-red-700">
                                                &times;
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" id="add_doe_number" 
                                        class="mt-2 bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                        Adicionar
                                </button>
                            </div>
                            
                            <script>
                                document.getElementById('add_doe_number').addEventListener('click', function () {
                                    const container = document.getElementById('doe_numbers_container');
                            
                                    // Cria o contêiner do novo campo
                                    const fieldContainer = document.createElement('div');
                                    fieldContainer.classList.add('flex', 'items-center', 'space-x-2', 'mt-1');
                            
                                    // Cria o input
                                    const input = document.createElement('input');
                                    input.type = 'text';
                                    input.name = 'doe_numbers[]';
                                    input.placeholder = 'Número do diário';
                                    input.required = true;
                                    input.classList.add('block', 'w-full', 'rounded-md', 'border-gray-300', 'shadow-sm');
                            
                                    // Cria o botão de remover
                                    const removeButton = document.createElement('button');
                                    removeButton.type = 'button';
                                    removeButton.innerHTML = '&times;';
                                    removeButton.classList.add('remove-button', 'text-red-500', 'font-bold', 'hover:text-red-700');
                            
                                    // Adiciona evento de remoção ao botão
                                    removeButton.addEventListener('click', function () {
                                        fieldContainer.remove();
                                    });
                            
                                    // Adiciona os elementos ao contêiner do novo campo
                                    fieldContainer.appendChild(input);
                                    fieldContainer.appendChild(removeButton);
                            
                                    // Adiciona o novo campo ao contêiner principal
                                    container.appendChild(fieldContainer);
                                });
                            
                                // Adiciona funcionalidade de remoção aos botões existentes
                                document.querySelectorAll('.remove-button').forEach(button => {
                                    button.addEventListener('click', function () {
                                        button.parentElement.remove();
                                    });
                                });
                            </script>

                            <!-- END DOE -->

                            <div>
                                <label for="effective_date"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data de
                                    Publicação</label>
                                <input type="date" name="effective_date" id="effective_date"
                                    value="{{ old('effective_date', $decree->effective_date->format('Y-m-d')) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:text-gray-100">
                                @error('effective_date')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mt-10">
                                <div class="col-span-full">
                                    <label for="file_pdf" class="block text-sm font-medium text-gray-900">Arquivo
                                        PDF</label>
                                    <div class="mt-2 flex items-center gap-x-3">

                                        <!-- Ícone de PDF -->
                                        <svg class="h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor"
                                            aria-hidden="true">
                                            <path
                                                d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-7-7zM13 3.5L18.5 9H13V3.5zM7.5 17.5V16h2.25a.75.75 0 1 0 0-1.5H7.5v-1h2.25a.75.75 0 1 0 0-1.5H7.5v-1.5h4.25a.75.75 0 1 1 0 1.5H10.5v1h1.75a.75.75 0 1 1 0 1.5H10.5v1h1.25a.75.75 0 1 1 0 1.5H7.5z" />
                                        </svg>

                                        <!-- Botão para selecionar PDF -->
                                        <input type="file" id="file_pdf" name="file_pdf" accept="application/pdf"
                                            class="hidden" onchange="handlePDFChange(event)">
                                        <button type="button" onclick="document.getElementById('file_pdf').click()"
                                            class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Selecionar
                                            PDF</button>
                                        <span id="pdf-file-name" class="text-sm text-gray-500 ml-2">Nenhum arquivo
                                            selecionado</span>
                                    </div>
                                </div>
                                @error('file_pdf')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Preview do PDF -->
                            @if ($decree->file_pdf)
                                <div class="mt-2" id="pdf-preview">
                                    <object id="pdf-object" data="{{ asset('storage/' . $decree->file_pdf) }}"
                                        type="application/pdf" width="100%" height="600px"
                                        class="border-gray-300 rounded-lg shadow-sm">
                                        <p>Seu navegador não suporta visualização de PDFs.
                                            <a href="{{ asset('storage/' . $decree->file_pdf) }}" id="pdf-link"
                                                target="_blank">Clique aqui para baixar o PDF.</a>
                                        </p>
                                    </object>
                                </div>
                            @endif

                            <!-- Ementa -->
                            <div class="mt-10">
                                <label for="summary"
                                    class="block text-sm font-bold text-gray-700 dark:text-gray-300">Ementa</label>
                                <textarea name="summary" id="summary" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:text-gray-100"
                                    placeholder="Digite a ementa do decreto">{{ old('summary', $decree->summary) }}</textarea>
                                @error('summary')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Conteúdo -->
                            <div class="mt-10">
                                <style>
                                    .note-editable {
                                        /* Corrigindo overflow do editor */
                                        padding-right: 2em !important;
                                    }
                                </style>
                                <label for="content"
                                    class="block text-sm font-bold text-gray-700 dark:text-gray-300">Conteúdo</label>
                                <textarea name="content" id="content" placeholder="Digite o conteúdo do decreto">
                                    {{ old('content', $decree->content) }}
                                </textarea>
                                @error('content')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                                <script>
                                    $('#content').summernote({
                                        lang: 'pt-BR',
                                        fontSizes: ['8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '24', '36', '48', '64'],
                                        toolbar: [
                                            // [groupName, [list of button]]
                                            ['style', ['bold', 'italic', 'underline', 'clear']],
                                            ['font', ['strikethrough', 'superscript', 'subscript']],
                                            ['para', ['ul', 'ol', 'paragraph']],
                                            ['height', ['height']],
                                            ['color', ['color']],
                                            ['fontname', ['fontname']],
                                            ['fontsize', ['fontsize']],
                                            ['link', ['link']],
                                            ['picture', ['picture']],
                                            ['table', ['table']],
                                            ['codeview', ['codeview']],
                                            ['insert', ['gxcode']],
                                            ['fullscreen', ['fullscreen']]
                                        ]
                                    });
                                </script>
                            </div>
                            <!-- end Conteúdo -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="pt-2 pb-40">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 text-gray-900 dark:text-gray-100 flex justify-between">
                        <div>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                Salvar
                            </button>
                            <a href="{{ route('decrees.index') }}"
                                class="ml-4 px-4 py-2 bg-gray-600 text-white rounded">Cancelar</a>
                        </div>
                        <a href="{{ route('decrees.show', $decree->id) }}"
                            class="ml-4 px-4 py-2 bg-green-600 text-white rounded"><i class="fa-solid fa-search"></i>
                            Ver</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        function previewPDF(event) {
            const file = event.target.files[0];
            if (file && file.type === "application/pdf") {
                const fileURL = URL.createObjectURL(file);
                const pdfObject = document.getElementById('pdf-object');
                const pdfLink = document.getElementById('pdf-link');

                // Mostra a pré-visualização do PDF
                document.getElementById('pdf-preview').classList.remove('hidden');
                pdfObject.data = fileURL;
                pdfLink.href = fileURL;
            }
        }

        function handlePDFChange(event) {
            const file = event.target.files[0];
            const fileNameSpan = document.getElementById('pdf-file-name');
            if (file) {
                fileNameSpan.textContent = file.name; // Exibe o nome do arquivo selecionado
                previewPDF(event);
            } else {
                fileNameSpan.textContent = 'Nenhum arquivo selecionado';
            }
        }
    </script>
</x-app-layout>
