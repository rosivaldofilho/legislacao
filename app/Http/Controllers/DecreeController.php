<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Decree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DecreeController extends Controller
{
    // MARK: INDEX
    public function index(Request $request)
    {
        // Define o campo de ordenação padrão e a direção padrão
        $sort = $request->get('sort', 'created_at'); // Ordenação padrão pelo campo 'number'
        $direction = $request->get('direction', 'desc'); // Direção padrão 'asc'

        // Verifica se o campo de ordenação é válido e seguro
        if (!in_array($sort, ['number', 'doe_numbers', 'effective_date', 'summary', 'created_at'])) {
            $sort = 'number';
        }

        // Verifica se a direção de ordenação é válida ('asc' ou 'desc')
        $direction = $direction === 'desc' ? 'desc' : 'asc';

        // Realiza a busca e ordenação no banco de dados com paginação
        $decrees = Decree::orderBy($sort, $direction)->paginate(10);

        // Passa as variáveis para a view
        return view('decrees.index', compact('decrees', 'sort', 'direction'));
    }

    // MARK: SHOW
    public function show($number)
    {
        $decree = Decree::where('number', $number)->firstOrFail();
        // Carrega anexos do decreto, se houver relação com 'attachments'
        $decree->load('attachments');

        // Retorna a view de exibição do decreto com os dados do decreto
        return view('decrees.show', compact('decree'));
    }

    public function create()
    {
        // Mostrar o formulário para criar um novo Decree
        return view('decrees.create');
    }

    // MARK: SEARCH
    public function search(Request $request)
    {
        $query = Decree::query();

        // Filtros
        if ($request->filled('number')) {
            $query->where('number', 'like', '%' . $request->input('number') . '%');
        }

        if ($request->filled('doe_numbers')) {
            $query->where('doe_numbers', 'like', '%' . $request->input('doe_numbers') . '%');
        }

        if ($request->filled('effective_date')) {
            $query->whereDate('effective_date', $request->input('effective_date'));
        }

        if ($request->filled('summary')) {
            $query->where('summary', 'like', '%' . $request->input('summary') . '%');
        }

        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->input('created_at'));
        }

        // Ordenação
        if ($request->filled('sort_by') && $request->filled('sort_order')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_order'));
        }

        $decrees = $query->paginate(10);

        return view('decrees.search', compact('decrees'));
    }

    // MARK: STORE
    public function store(Request $request)
    {
        // Validar os dados do formulário
        $validated = $request->validate([
            'number' => 'required|unique:decrees',
            'doe_numbers' => 'required|array', // Verifica se é uma lista
            'doe_numbers.*' => 'required|string', // Verifica cada item da lista
            'effective_date' => 'required|date',
            'summary' => 'required|max:255',
            'content' => 'required',
            'file_pdf' => 'file|mimes:pdf|max:5120', // até 5MB por arquivo
            'attachments.*.file' => 'nullable|file|mimes:pdf|max:2048',
            'attachments.*.description' => 'nullable|string|max:255'
        ]);


        // Criar um novo Decree

        // Processa o upload do arquivo PDF, se houver
        if ($request->hasFile('file_pdf')) {
            $validated['file_pdf'] = $request->file('file_pdf')->store('pdf', 'public');
        }


        $decree = new Decree($validated);
        $decree->doe_numbers = $validated['doe_numbers'];
        $decree->user_id = Auth::id(); // Registrar o usuário que criou


        if ($request->has('attachments')) {
            foreach ($request->attachments as $attachment) {
                if (isset($attachment['file'])) {
                    $path = $attachment['file']->store('attachments', 'public');
                    $decree->attachments()->create([
                        'file_path' => $path,
                        'description' => $attachment['description'] ?? null,
                    ]);
                }
            }
        }

        $decree->save();

        return redirect()->route('decrees.show', $decree->number)->with('success', 'Decreto cadastrado com sucesso!');
    }

    public function edit(Decree $decree)
    {
        // Mostrar o formulário para editar um Decree
        return view('decrees.edit', compact('decree'));
    }

    // MARK: UPDATE
    public function update(Request $request, Decree $decree)
    {
        // Validar os dados do formulário
        $validated = $request->validate([
            'number' => 'required|unique:decrees,number,' . $decree->id,
            'doe_numbers' => 'required|array', // Verifica se é uma lista
            'doe_numbers.*' => 'required|string', // Verifica cada item da lista
            'effective_date' => 'required|date',
            'summary' => 'required|max:255',
            'content' => 'required',
            'file_pdf' => 'file|mimes:pdf|max:5120', // até 5MB por arquivo
            'attachments.*.file' => 'nullable|file|mimes:pdf|max:2048',
            'attachments.*.description' => 'nullable|string|max:255'
        ]);

        //dd($validated['doe_numbers']);
        // Adicionando a lista de números do DOE
        $decree->doe_numbers = $validated['doe_numbers'];

        // Processa o upload de um novo arquivo PDF, se houver
        if ($request->hasFile('file_pdf')) {

            // Exclui o arquivo PDF anterior, se existir
            if ($decree->file_pdf && Storage::disk('public')->exists($decree->file_pdf)) {
                Storage::disk('public')->delete($decree->file_pdf);
            }

            // Armazena o novo arquivo e atualiza o caminho
            $validated['file_pdf'] = $request->file('file_pdf')->store('pdf', 'public');
        }

        // ANEXOS
        // Processa os anexos marcados para exclusão

        if ($request->has('attachments_to_remove')) {
            foreach ($request->attachments_to_remove as $attachmentId) {
                $attachment = Attachment::find($attachmentId);
                if ($attachment) {
                    // Exclui o arquivo fisicamente
                    Storage::delete($attachment->file_path);
                    $attachment->delete();
                }
            }
        }

        // Processa anexos existentes (atualização de descrição)
        if ($request->has('attachments_existing')) {
            foreach ($request->attachments_existing as $attachmentId => $data) {
                $attachment = Attachment::find($attachmentId);
                if ($attachment) {
                    $attachment->description = $data['description'];
                    $attachment->save();
                }
            }
        }

        // Processa novos anexos
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $decree->attachments()->create([
                    'file_path' => $file->store('attachments'),
                    'description' => $file['description'],
                ]);
            }
        }

        // Atualizar o Decree
        $decree->update($validated);

        // Salvar novos arquivos anexados, se houver

        return redirect()->route('decrees.show', $decree->number)->with('success', 'Decreto atualizado com sucesso!');
    }

    // MARK: DESTROY
    public function destroy(Decree $decree)
    {
        // Excluir o Decree (exclusão lógica)
        $decree->delete();
        return redirect()->route('decrees.index')->with('success', 'Decreto deletado com sucesso!');
    }

    public function restore($id)
    {
        // Restaurar um Decree excluído
        $decree = Decree::withTrashed()->findOrFail($id);
        $decree->restore();
        return redirect()->route('decrees.index')->with('success', 'Decreto restaurado com sucesso!');
    }



    public function updateAttachments(Request $request, Decree $decree)
    {
        $validated = $request->validate([
            'attachments_existing.*.id' => 'integer|exists:attachments,id',
            'attachments_existing.*.description' => 'string|max:255',
            'attachments.*.file' => 'file|mimes:pdf|max:2048',
            'attachments.*.description' => 'string|max:255',
        ]);

        // IDs dos anexos enviados no formulário
        $existingAttachmentIds = collect($validated['attachments_existing'] ?? [])->pluck('id')->all();

        // IDs dos anexos atualmente no banco
        $currentAttachmentIds = $decree->attachments()->pluck('id')->all();

        // Remover anexos que não estão no request
        $attachmentsToRemove = array_diff($currentAttachmentIds, $existingAttachmentIds);

        foreach ($attachmentsToRemove as $id) {
            $attachment = $decree->attachments()->find($id);
            if ($attachment) {
                Storage::delete($attachment->file_path); // Excluir o arquivo
                $attachment->delete(); // Remover do banco
            }
        }

        // Atualizar descrições dos anexos existentes
        if (!empty($validated['attachments_existing'])) {
            foreach ($validated['attachments_existing'] as $existing) {
                $attachment = $decree->attachments()->find($existing['id']);
                if ($attachment) {
                    $attachment->update(['description' => $existing['description']]);
                }
            }
        }

        // Adicionar novos anexos
        if (!empty($validated['attachments'])) {
            foreach ($validated['attachments'] as $newAttachment) {
                
                $path = $newAttachment['file']->store('attachments', 'public');
                $decree->attachments()->create([
                    'file_path' => $path,
                    'description' => $newAttachment['description'],
                ]);
            }
        }

        return redirect()->route('decrees.show', $decree->number)->with('success', 'Anexos atualizados com sucesso!');
    }
}
