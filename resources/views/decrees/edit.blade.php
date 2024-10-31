@extends('layouts.app')

@section('content')
<h1>Editar Decreto</h1> <!-- Alterado para Editar Decreto -->

<form action="{{ route('decrees.update', $decree) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="number" class="form-label">Número</label>
        <input type="text" class="form-control" id="number" name="number" value="{{ $decree->number }}" required>
    </div>

    <div class="mb-3">
        <label for="effective_date" class="form-label">Data de Publicação</label> <!-- Alterado para Data de Publicação -->
        <input type="date" class="form-control" id="effective_date" name="effective_date" value="{{ $decree->effective_date->format('Y-m-d') }}" required>
    </div>

    <div class="mb-3">
        <label for="summary" class="form-label">Ementa</label> <!-- Alterado para Ementa -->
        <input type="text" class="form-control" id="summary" name="summary" value="{{ $decree->summary }}" required>
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Conteúdo</label>
        <textarea class="form-control" id="content" name="content" rows="5" required>{{ $decree->content }}</textarea>
    </div>

    <div class="mb-3">
        <label for="attachments" class="form-label">Anexos (PDF)</label>
        <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
    </div>

    <button type="submit" class="btn btn-success">Salvar</button> <!-- Alterado para Salvar -->
    <a href="{{ route('decrees.index') }}" class="btn btn-secondary">Voltar</a>
</form>
@endsection
