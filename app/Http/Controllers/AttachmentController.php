<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Decree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Decree $decree)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:2048',
            'description' => 'required|string|max:255',
        ]);

        $filePath = $request->file('file')->store('attachments', 'public');

        $decree->attachments()->create([
            'file_path' => $filePath,
            'description' => $request->input('description'),
        ]);

        return redirect()->route('decrees.show', $decree)
            ->with('success', 'Anexo adicionado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attachment $attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attachment $attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateAttachments(Request $request, Decree $decree)
    {
        $request->validate([
            'existing_descriptions.*' => 'string|max:255|nullable',
            'delete_attachments.*' => 'integer|exists:attachments,id',
            'attachments.*' => 'file|mimes:pdf|max:2048',
            'descriptions.*' => 'string|max:255|nullable',
        ]);
    
        // Atualizar descrições de anexos existentes
        if ($request->has('existing_descriptions')) {
            foreach ($request->existing_descriptions as $id => $description) {
                $attachment = $decree->attachments()->find($id);
                if ($attachment) {
                    $attachment->update(['description' => $description]);
                }
            }
        }
    
        // Remover anexos marcados
        if ($request->has('delete_attachments')) {
            foreach ($request->delete_attachments as $id) {
                $attachment = $decree->attachments()->find($id);
                if ($attachment) {
                    // Remover arquivo do storage
                    Storage::delete($attachment->file_path);
                    $attachment->delete();
                }
            }
        }
    
        // Adicionar novos anexos
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $index => $file) {
                $path = $file->store('attachments', 'public');
                $decree->attachments()->create([
                    'file_path' => $path,
                    'description' => $request->descriptions[$index] ?? null,
                ]);
            }
        }
    
        return redirect()->route('decrees.show', $decree)->with('success', 'Anexos atualizados com sucesso!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attachment $attachment)
    {
        // Exclui o arquivo físico
        if (Storage::exists($attachment->file_path)) {
            Storage::delete($attachment->file_path);
        }

        // Exclui o registro do banco de dados
        $attachment->delete();

        return response()->json(['success' => true, 'message' => 'Attachment deleted successfully.']);
    }
}
