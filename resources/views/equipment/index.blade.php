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


</div>
@endsection