{{-- resources/views/cost-centers/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Cadastro de Centro de Custos</h2>
    
    <form action="{{ route('cost-centers.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="form-group">
            <label for="code">Código</label>
            <input type="text" name="code" id="code" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Descrição</label>
            <input type="text" name="description" id="description" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

    <div class="mt-4">
        <h3>Centros de Custo Cadastrados</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Total de Funcionários</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($costCenters as $center)
                    <tr>
                        <td>{{ $center->code }}</td>
                        <td>{{ $center->description }}</td>
                        <td>{{ $center->employees_count }}</td>
                        <td>
                            <form action="{{ route('cost-centers.destroy', $center) }}" method="POST" style="display: inline;">
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