{{-- resources/views/decrees/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Criar Novo Decreto') }}
        </h2>
    </x-slot>
    <div class="pb-20">
        <form action="{{ route('decrees.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="pt-2">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
                        <div class="px-6 py-4 text-gray-900 dark:text-gray-100">

                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                Salvar
                            </button>

                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">


                            <div class="grid grid-cols-1 gap-6 mx-auto pt-10">
                                <div>
                                    <label for="number"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número</label>
                                    <input type="text" name="number" id="number" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:text-gray-100"
                                        placeholder="Digite o número do decreto">
                                </div>

                                <!-- DOE -->

                                <div>
                                    <label for="doe_numbers" class="block text-sm font-medium text-gray-700">Publicações
                                        no DOE</label>
                                    <div id="doe_numbers_container">
                                        <div class="flex items-center space-x-2">
                                            <input type="text" name="doe_numbers[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                                placeholder="DOE Number" required>
                                            <button type="button"
                                                class="remove-button text-red-500 font-bold hover:text-red-700 hidden">
                                                &times;
                                            </button>
                                        </div>
                                    </div>
                                    <button type="button" id="add_doe_number"
                                        class="mt-2 bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                        Adicionar
                                    </button>
                                </div>

                                <script>
                                    document.getElementById('add_doe_number').addEventListener('click', function() {
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
                                        removeButton.addEventListener('click', function() {
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
                                        button.addEventListener('click', function() {
                                            button.parentElement.remove();
                                        });
                                    });
                                </script>

                                <!-- END DOE -->

                                <div>
                                    <label for="effective_date"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data de
                                        Publicação</label>
                                    <input type="date" name="effective_date" id="effective_date" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:text-gray-100">
                                </div>

                                <div class="col-span-full">
                                    <label for="file_pdf" class="block text-sm font-medium text-gray-900">PDF do
                                        Decreto</label>
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

                                <div id="pdf-preview" class="mt-2 mb-6 hidden">
                                    <object id="pdf-object" type="application/pdf" width="100%" height="500px"
                                        class="border-gray-300 rounded-md shadow-sm">
                                        <p>Pré-visualização do PDF não disponível. <a href="" id="pdf-link"
                                                target="_blank">Clique aqui para abrir.</a></p>
                                    </object>
                                </div>

                                <div>
                                    <label for="summary"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ementa</label>
                                    <textarea name="summary" id="summary" rows="2" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:text-gray-100"
                                        placeholder="Digite a ementa do decreto"></textarea>
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

                                <!-- ANEXOS -->
                                <div id="attachments-container">
                                    <h3 class="text-lg font-medium text-gray-900">Anexos</h3>
                                    <div class="mt-2">
                                        <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded-md"
                                            onclick="addAttachment()">Adicionar Anexo</button>
                                    </div>
                                    <div class="mt-4 space-y-4">
                                        <template id="attachment-template">
                                            <div class="flex items-center gap-4">
                                                <input type="file" name="attachments[][file]" class="block w-1/2">
                                                <input type="text" name="attachments[][description]"
                                                    placeholder="Description"
                                                    class="block w-1/2 rounded-md border-gray-300 shadow-sm">
                                                <button type="button" class="text-red-500"
                                                    onclick="removeAttachment(this)">Remove</button>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <script>
                                    function addAttachment() {
                                        const container = document.getElementById('attachments-container');
                                        const template = document.getElementById('attachment-template').content.cloneNode(true);
                                        container.appendChild(template);
                                    }

                                    function removeAttachment(button) {
                                        button.closest('div').remove();
                                    }
                                </script>

                                <!-- END ANEXOS -->

                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-4">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">

                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                Salvar
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
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
