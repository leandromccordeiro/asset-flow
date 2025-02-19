{{-- resources/views/gadget-models/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Cadastro de Modelos de Equipamento</h2>
    
    <form action="{{ route('gadget-models.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="form-group">
            <label for="type">Tipo</label>
            <input type="text" name="type" id="type" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="brand">Marca</label>
            <input type="text" name="brand" id="brand" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="model">Modelo</label>
            <input type="text" name="model" id="model" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

    <div class="mt-4">
        <h3>Modelos Cadastrados</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gadgetModels as $model)
                    <tr>
                        <td>{{ $model->type }}</td>
                        <td>{{ $model->brand }}</td>
                        <td>{{ $model->model }}</td>
                        <td>
                            <form action="{{ route('gadget-models.destroy', $model) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Tem certeza que deseja excluir?')">
                                    Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection