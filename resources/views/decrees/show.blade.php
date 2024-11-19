<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalhes do Decreto') }}
        </h2>
    </x-slot>

    <div class="pt-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 text-gray-900 dark:text-gray-100 flex">
                    <a href="{{ route('decrees.edit', $decree->id) }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md text-xs uppercase">
                        Editar
                    </a>
                    <a href="{{ route('decrees.index') }}"
                        class="ml-4 px-4 py-2 bg-gray-600 text-white rounded-md text-xs">Voltar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 text-gray-900 dark:text-gray-100 flex justify-between">
                    <div>
                        <p class="text-gray-600">Decreto, nº <span class="font-bold">{{ $decree->number }}</span> de {{ \Carbon\Carbon::parse($decree->effective_date)->format('d/m/Y') }}</p>
                        <p class="text-gray-600">Publicado no diário: 
                            <span class="text-blue-600"><a href="https://diariooficial.to.gov.br/busca/?por=edicao&edicao={{ $decree->doe_number }}"
                                    target="_blank">DOE {{ $decree->doe_number }}</a></spanp>
                        </p>
                    </div>
                    <div class="content-center">
                        @if ($decree->file_pdf)
                            <a href="{{ asset('storage/' . $decree->file_pdf) }}" target="_blank"
                                class="text-blue-500 text-2xl">
                                <span class="text-lg"><i class="fa-solid fa-arrow-down"></i></span> <i class="fa-regular fa-file-pdf"></i>
                            </a>
                        @endif
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
                            <img class="mx-auto" src="{{ asset('/img/governo_do_estado_do_tocantins.jpg') }}" alt="governo do estado do Tocantins">
                            <div class="break-words" id="conteudo_documento">{!! $decree->content !!}</div>
                        </div>
                        <script>
                            $(document).ready(function () {
                                const fix_style = "float-right w-4/5 md:w-1/2 mt-4 mb-4 text-justify";
                                $('p[style*="7cm"]').attr("class", fix_style);
                                $('p[class^="float-right"]').next('p').addClass('clear-both');
                                
                                $('p[style*="7cm"]').attr("style", "");
                                $('table').addClass('table-auto');
                                //$('table').parent().addClass('overflow-x-auto');
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
