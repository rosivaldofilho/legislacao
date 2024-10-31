@extends('layouts.app')

@section('content')
<h1>Cadastro de Decreto</h1>

<form action="{{ route('decrees.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="number" class="form-label">Número</label>
        <input type="text" class="form-control" id="number" name="number" required>
    </div>

    <div class="mb-3">
        <label for="effective_date" class="form-label">Data de Publicação</label> <!-- Data de Publicação -->
        <input type="date" class="form-control" id="effective_date" name="effective_date" required>
    </div>

    <div class="mb-3">
        <label for="summary" class="form-label">Ementa</label> <!-- Ementa -->
        <input type="text" class="form-control" id="summary" name="summary" required>
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Conteúdo</label>
        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
    </div>

    <div class="mb-3">
        <label for="attachments" class="form-label">Anexos (PDF)</label>
        <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
    </div>

    <button type="submit" class="btn btn-success">Salvar</button> <!-- Salvar -->
    <a href="{{ route('decrees.index') }}" class="btn btn-secondary">Voltar</a>
</form>
@endsection
