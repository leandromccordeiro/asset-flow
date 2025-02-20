{{-- resources/views/reports/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2>Relatório de Equipamentos</h2>
        </div>
        <div class="card-body">
            <!-- Relatório de Equipamentos -->
            <div class="mb-4">
                <form action="{{ route('reports.equipment') }}" method="GET" class="mt-3">
                    <div class="form-group">
                        <label>Status do Equipamento</label>
                        <select name="is_available" class="form-control">
                            <option value="">Todos</option>
                            <option value="1">Disponíveis</option>
                            <option value="0">Em Uso</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Gerar Relatório</button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection