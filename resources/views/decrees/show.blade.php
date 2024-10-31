@extends('layouts.app')

@section('content')
<h1>Detalhes do Decreto</h1>

<div class="mb-3">
    <label class="form-label"><strong>Número:</strong></label>
    <p>{{ $decree->number }}</p>
</div>

<div class="mb-3">
    <label class="form-label"><strong>Data de Publicação:</strong></label> <!-- Alterado para Data de Publicação -->
    <p>{{ $decree->effective_date->format('d/m/Y') }}</p>
</div>

<div class="mb-3">
    <label class="form-label"><strong>Ementa:</strong></label> <!-- Alterado para Ementa -->
    <p>{{ $decree->summary }}</p>
</div>

<div class="mb-3">
    <label class="form-label"><strong>Conteúdo:</strong></label>
    <p>{{ $decree->content }}</p>
</div>

@if($decree->attachments)
    <div class="mb-3">
        <label class="form-label"><strong>Anexos:</strong></label>
        <ul>
            @foreach($decree->attachments as $attachment)
                <li>
                    <a href="{{ asset('storage/' . $attachment) }}" target="_blank">{{ basename($attachment) }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endif

<a href="{{ route('decrees.index') }}" class="btn btn-secondary">Voltar</a>
@endsection
