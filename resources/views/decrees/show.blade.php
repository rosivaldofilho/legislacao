<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalhes do Decreto') }}
        </h2>
    </x-slot>

    <div class="pt-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 text-gray-900 dark:text-gray-100 flex justify-between">
                    <div>
                        <a href="{{ route('decrees.edit', $decree->id) }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md text-xs uppercase">
                            Editar
                        </a>
                        <a href="{{ route('decrees.index') }}"
                            class="ml-4 px-4 py-2 bg-gray-600 text-white rounded-md text-xs">Voltar</a>
                    </div>
                    <div class="content-center">
                        @if ($decree->file_pdf)
                            <a href="{{ asset('storage/' . $decree->file_pdf) }}" target="_blank"
                                class="text-blue-500 text-2xl">
                                <span class="text-lg"><i class="fa-solid fa-arrow-down"></i></span> <i
                                    class="fa-regular fa-file-pdf"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <!-- MODAL ANEXOS-->
        <div id="attachmentModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">

            <div class="bg-white w-full max-w-3xl rounded-lg shadow-lg p-6 relative">
                <!-- Botão para fechar -->
                <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-800" onclick="toggleModal()">
                    ✖
                </button>

                <!-- Conteúdo do modal -->
                <h2 class="text-lg font-bold text-gray-800 mb-4">Gerenciar Anexos</h2>

                <form action="{{ route('decrees.updateAttachments', $decree) }}" method="POST"
                    enctype="multipart/form-data" id="attachmentForm">
                    @csrf
                    @method('PUT')

                    <div id="attachmentFields">
                        <!-- Loop pelos anexos existentes -->
                        @foreach ($decree->attachments as $attachment)
                            <div class="flex items-center space-x-4 mb-4 attachment-field"
                                data-attachment-id="{{ $attachment->id }}">
                                <input type="hidden" name="attachments_existing[{{ $attachment->id }}][id]"
                                    value="{{ $attachment->id }}" />

                                <input type="text" name="attachments_existing[{{ $attachment->id }}][description]"
                                    value="{{ $attachment->description }}" placeholder="Descrição do anexo"
                                    class="w-full border-gray-300 rounded" required />

                                <a href="{{ Storage::url($attachment->file_path) }}" target="_blank"
                                    class="text-blue-600 hover:underline">
                                    Visualizar
                                </a>

                                <button type="button" class="text-red-500 hover:text-red-700"
                                    onclick="removeAttachment(this)">
                                    Remover
                                </button>
                            </div>
                        @endforeach
                    </div>



                    <!-- Botão para adicionar novos anexos -->
                    <button type="button" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                        onclick="addAttachmentField()">
                        Adicionar Anexo
                    </button>

                    <!-- Botão para salvar -->
                    <div class="mt-6">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END MODAL ANEXOS -->
        <script>
            function toggleModal() {
                const modal = document.getElementById('attachmentModal');
                modal.classList.toggle('hidden');
            }

            document.addEventListener("DOMContentLoaded", () => {
                // Lida com a remoção de anexos existentes
                document.querySelectorAll(".remove-attachment-btn").forEach(button => {
                    button.addEventListener("click", (event) => {
                        const wrapper = event.target.closest(".attachment-field");
                        const attachmentId = wrapper.dataset.attachmentId;

                        if (attachmentId) {
                            // Cria um campo hidden para marcar o anexo para exclusão
                            const hiddenInput = document.createElement("input");
                            hiddenInput.type = "hidden";
                            hiddenInput.name = "attachments_to_remove[]";
                            hiddenInput.value = attachmentId;
                            document.getElementById("attachmentFields").appendChild(hiddenInput);
                        }

                        wrapper.remove(); // Remove o anexo da interface
                    });
                });
            });

            function addAttachmentField(existingAttachmentId = null) {
                const container = document.getElementById('attachmentFields');
                const index = container.children.length;

                const wrapper = document.createElement('div');
                wrapper.classList.add('flex', 'items-center', 'space-x-4', 'mb-4', 'attachment-field');

                if (existingAttachmentId) {
                    wrapper.dataset.attachmentId = existingAttachmentId; // Para anexos já existentes
                }

                // Campo de upload do arquivo (somente para novos anexos)
                if (!existingAttachmentId) {
                    const fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = `attachments[${index}][file]`;
                    fileInput.classList.add('w-full', 'border-gray-300', 'rounded');
                    fileInput.required = true;
                    wrapper.appendChild(fileInput);
                }

                // Campo de descrição (para anexos novos ou existentes)
                const descriptionInput = document.createElement('input');
                descriptionInput.type = 'text';
                descriptionInput.name = existingAttachmentId ?
                    `attachments_existing[${existingAttachmentId}][description]` :
                    `attachments[${index}][description]`;
                descriptionInput.placeholder = 'Descrição do anexo';
                descriptionInput.classList.add('w-full', 'border-gray-300', 'rounded');
                descriptionInput.required = true;
                wrapper.appendChild(descriptionInput);

                // Botão de remoção
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.textContent = 'Remover';
                removeButton.classList.add('text-red-500', 'hover:text-red-700');
                removeButton.onclick = () => {
                    if (existingAttachmentId) {
                        // Adiciona um campo hidden para marcar o anexo para exclusão
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = `attachments_to_remove[]`;
                        hiddenInput.value = existingAttachmentId;
                        container.appendChild(hiddenInput);
                    }
                    wrapper.remove(); // Remove visualmente
                };
                wrapper.appendChild(removeButton);

                container.appendChild(wrapper);
            }



            function removeAttachment(button) {
                const fieldGroup = button.closest('.flex');
                fieldGroup.remove();
            }
        </script>

    </div>

    <div class="pt-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 text-gray-900 dark:text-gray-100 flex justify-between">
                    <div>
                        <p class="text-gray-600">Decreto, nº <span class="font-bold">{{ $decree->number }}</span> de
                            {{ \Carbon\Carbon::parse($decree->effective_date)->format('d/m/Y') }}</p>

                    </div>
                    <div>
                        @if ($decree->doe_numbers)
                            <p class="text-lg font-medium text-gray-900">Publicações no diário: </p>
                            <ul class="list-disc ml-5">
                                @foreach ($decree->doe_numbers as $number)
                                    <li class="text-blue-600"><a
                                            href="https://diariooficial.to.gov.br/busca/?por=edicao&edicao={{ $number }}"
                                            target="_blank">DOE {{ $number }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 text-gray-900 dark:text-gray-100 flex justify-between">
                    <div>
                        @if ($decree->attachments)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Anexos</h3>
                                <ul class="list-disc list-inside">
                                    @foreach ($decree->attachments as $attachment)
                                        <li>
                                            <a href="{{ Storage::url($attachment->file_path) }}" target="_blank"
                                                class="text-blue-500 hover:underline">
                                                {{ $attachment->description ?? 'Ver arquivo' }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                    <div class="content-center">
                        <a href="#" onclick="toggleModal()" class="text-blue-500 text-2xl">
                            <i class="fa-regular fa-edit"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="pt-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Informações sobre o decreto --}}
                    <div class="grid grid-cols-1 gap-6">
                        <div class=" md:px-4 lg:px-40">
                            <img class="mx-auto" src="{{ asset('/img/governo_do_estado_do_tocantins.jpg') }}"
                                alt="governo do estado do Tocantins">
                            {{-- Título --}}
                            <div class="break-words flex justify-center text-center font-bold">
                                <span>DECRETO Nº {{ $decree->number }}, de
                                    {{ $decree->effective_date->locale('pt-BR')->translatedFormat('d F Y') }}</span>
                            </div>
                            {{-- Ementa --}}
                            <div class="break-words float-right w-4/5 md:w-1/2 mt-4 text-justify"
                                style="font-size:12.0pt;font-family:Arial,sans-serif;margin-bottom:0cm;text-align:justify;text-indent:2.0cm;line-height:normal">
                                <span style="">{{ $decree->summary }}</span>
                            </div>
                            <div class="clear-both"></div>
                            {{-- Conteúdo --}}
                            <div class="break-words mt-4" id="conteudo_documento">{!! $decree->content !!}</div>
                        </div>
                        <script>
                            $(document).ready(function() {
                                //const fix_style = "float-right w-4/5 md:w-1/2 mt-4 mb-4 text-justify";
                                //$('p[style*="7cm"]').attr("class", fix_style);
                                //$('p[class^="float-right"]').next('p').addClass('clear-both');
                                //$('p[style*="7cm"]').attr("style", "");
                                $('table').addClass('table-auto');
                                $('table').addClass('overflow-x-auto');
                                $('table, td, th, tr').attr("width", "");
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-2 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 text-gray-900 dark:text-gray-100 flex">
                    <a href="{{ route('decrees.edit', $decree->id) }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded">
                        Editar Decreto
                    </a>
                    <a href="{{ route('decrees.index') }}"
                        class="ml-4 px-4 py-2 bg-gray-600 text-white rounded">Voltar</a>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
