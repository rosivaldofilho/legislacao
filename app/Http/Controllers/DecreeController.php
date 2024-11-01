<?php

namespace App\Http\Controllers;

use App\Models\Decree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DecreeController extends Controller
{
    public function index()
    {
        // Listar todos os Decrees
        $decrees = Decree::paginate(10); // 10 itens por página
        return view('decrees.index', compact('decrees'));
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
        $decree = new Decree($validated);
        $decree->user_id = Auth::id(); // Registrar o usuário que criou
        $decree->save();

        // Salvar os arquivos anexados
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $path = $attachment->store('attachments', 'public');
                $decree->attachments()->create(['file_pdf' => $path]);
            }
        }

        return redirect()->route('decrees.index')->with('success', 'Decree created successfully.');
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

        // Atualizar o Decree
        $decree->update($validated);

        // Salvar novos arquivos anexados, se houver

        return redirect()->route('decrees.index')->with('success', 'Decree updated successfully.');
    }

    public function destroy(Decree $decree)
    {
        // Excluir o Decree (exclusão lógica)
        $decree->delete();
        return redirect()->route('decrees.index')->with('success', 'Decree deleted successfully.');
    }

    public function restore($id)
    {
        // Restaurar um Decree excluído
        $decree = Decree::withTrashed()->findOrFail($id);
        $decree->restore();
        return redirect()->route('decrees.index')->with('success', 'Decree restored successfully.');
    }
}
