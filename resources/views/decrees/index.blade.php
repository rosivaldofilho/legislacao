@extends('layouts.app')

@section('content')
<h1>Lista de Decrees</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('decrees.create') }}" class="btn btn-primary mb-3">Adicionar Decree</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Número</th>
            <th>Data de Publicação</th>
            <th>Ementa</th> <!-- Troca de Resumo para Ementa -->
            <th>Data de Cadastro</th> <!-- Adicionada a Data de Cadastro -->
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($decrees as $decree)
            <tr>
                <td>{{ $decree->number }}</td>
                <td>{{ $decree->effective_date->format('d/m/Y') }}</td>
                <td>{{ $decree->summary }}</td> <!-- Resumo mantido como Ementa -->
                <td>{{ $decree->created_at->format('d/m/Y H:i:s') }}</td> <!-- Data de Cadastro -->
                <td>
                    <a href="{{ route('decrees.edit', $decree) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('decrees.destroy', $decree) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este decree?');">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@if($decrees->isEmpty())
    <div class="alert alert-info">Nenhum decree encontrado.</div>
@endif

@endsection
