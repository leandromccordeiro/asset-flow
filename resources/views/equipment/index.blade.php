{{-- resources/views/equipment/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Cadastro de Equipamentos</h2>
    
    <form action="{{ route('equipment.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="form-group">
            <label for="model">Modelo</label>
            <input type="text" name="model" id="model" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="brand">Marca</label>
            <input type="text" name="brand" id="brand" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="patrimony">Patrimônio</label>
            <input type="text" name="patrimony" id="patrimony" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="purchase_date">Data de Compra</label>
            <input type="date" name="purchase_date" id="purchase_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="is_available">Disponível</label>
            <select name="is_available" id="is_available" class="form-control" required>
                <option value="1">Sim</option>
                <option value="0">Não</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

    <div class="mt-4">
        <h3>Equipamentos Cadastrados</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Patrimônio</th>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Data de Compra</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($equipment as $item)
                    <tr>
                        <td>{{ $item->patrimony }}</td>
                        <td>{{ $item->model }}</td>
                        <td>{{ $item->brand }}</td>
                        <td>{{ $item->purchase_date->format('d/m/y') }}</td>
                        <td>
                            <span class="badge {{ $item->is_available ? 'bg-success' : 'bg-danger' }}">
                                {{ $item->is_available ? 'Disponível' : 'Em uso' }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('equipment.destroy', $item) }}" method="POST" style="display: inline;">
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