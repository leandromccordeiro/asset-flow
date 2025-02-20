{{-- resources/views/equipment/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Cadastro de Equipamentos</h2>
    
    <form action="{{ route('equipment.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="form-group">
            <label for="gadget_model_id">Modelo</label>
            <select name="gadget_model_id" id="gadget_model_id" class="form-control" required>
                <option value="">Selecione o modelo...</option>
                @foreach($gadgetModels->groupBy('type') as $type => $models)
                    <optgroup label="{{ $type }}">
                        @foreach($models as $model)
                            <option value="{{ $model->id }}">
                                {{ $model->brand }} - {{ $model->model }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-4"> {{-- exemplo para reduzir tamanho do input text --}}
            <label for="patrimony">Patrimônio</label>
            <input type="text" name="patrimony" id="patrimony" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="purchase_date">Data de Compra</label>
            <input type="date" name="purchase_date" id="purchase_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

    <div class="mt-4">
        <h3>Equipamentos Cadastrados</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Patrimônio</th>
                    <th>Tipo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Data de Compra</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($equipment as $item)
                    <tr>
                        <td>{{ $item->patrimony }}</td>
                        <td>{{ $item->gadgetModel->type }}</td>
                        <td>{{ $item->gadgetModel->brand }}</td>
                        <td>{{ $item->gadgetModel->model }}</td>
                        <td>{{ $item->purchase_date->format('d/m/Y') }}</td>
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