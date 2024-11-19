<?php

namespace App\Http\Controllers;

use App\Models\Decree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DecreeController extends Controller
{
    public function index(Request $request)
    {
        // Define o campo de ordenação padrão e a direção padrão
        $sort = $request->get('sort', 'created_at'); // Ordenação padrão pelo campo 'number'
        $direction = $request->get('direction', 'desc'); // Direção padrão 'asc'

        // Verifica se o campo de ordenação é válido e seguro
        if (!in_array($sort, ['number', 'doe_number', 'effective_date', 'summary', 'created_at'])) {
            $sort = 'number';
        }

        // Verifica se a direção de ordenação é válida ('asc' ou 'desc')
        $direction = $direction === 'desc' ? 'desc' : 'asc';

        // Realiza a busca e ordenação no banco de dados com paginação
        $decrees = Decree::orderBy($sort, $direction)->paginate(10);

        // Passa as variáveis para a view
        return view('decrees.index', compact('decrees', 'sort', 'direction'));
    }

    public function show(Decree $decree)
    {
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

    public function search(Request $request)
    {
        $query = Decree::query();

        // Filtros
        if ($request->filled('number')) {
            $query->where('number', 'like', '%' . $request->input('number') . '%');
        }

        if ($request->filled('doe_number')) {
            $query->where('doe_number', 'like', '%' . $request->input('doe_number') . '%');
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

    public function store(Request $request)
    {
        // Validar os dados do formulário
        $validated = $request->validate([
            'number' => 'required|unique:decrees',
            'doe_number' => 'required',
            'effective_date' => 'required|date',
            'summary' => 'required|max:255',
            'content' => 'required',
            'file_pdf' => 'file|mimes:pdf|max:5120' // até 5MB por arquivo
        ]);


        // Criar um novo Decree

        // Processa o upload do arquivo PDF, se houver
        if ($request->hasFile('file_pdf')) {
            $validated['file_pdf'] = $request->file('file_pdf')->store('pdf', 'public');
        }

        $decree = new Decree($validated);
        $decree->user_id = Auth::id(); // Registrar o usuário que criou
        $decree->save();

        return redirect()->route('decrees.index')->with('success', 'Decreto cadastrado com sucesso!');
    }

    public function edit(Decree $decree)
    {
        // Mostrar o formulário para editar um Decree
        return view('decrees.edit', compact('decree'));
    }

    public function update(Request $request, Decree $decree)
    {
        // Validar os dados do formulário
        $validated = $request->validate([
            'number' => 'required|unique:decrees,number,' . $decree->id,
            'doe_number' => 'required',
            'effective_date' => 'required|date',
            'summary' => 'required|max:255',
            'content' => 'required',
            'file_pdf' => 'file|mimes:pdf|max:5120' // até 5MB por arquivo
        ]);

        // Processa o upload de um novo arquivo PDF, se houver
        if ($request->hasFile('file_pdf')) {

            // Exclui o arquivo PDF anterior, se existir
            if ($decree->file_pdf && Storage::disk('public')->exists($decree->file_pdf)) {
                Storage::disk('public')->delete($decree->file_pdf);
            }

            // Armazena o novo arquivo e atualiza o caminho
            $validated['file_pdf'] = $request->file('file_pdf')->store('pdf', 'public');
        }

        // Atualizar o Decree
        $decree->update($validated);

        // Salvar novos arquivos anexados, se houver

        return redirect()->route('decrees.index')->with('success', 'Decreto atualizado com sucesso!');
    }

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
}
