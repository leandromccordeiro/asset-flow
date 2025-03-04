@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2>Relatório de Funcionários</h2>
        </div>
        <div class="card-body">

            <!-- Relatório de Funcionários -->
            <div class="mb-4">
                <form action="{{ route('reports.employees') }}" method="GET" class="mt-3">
                    <div class="form-group">
                        <label>Funcionário</label>
                        <select name="employee_id" class="form-control">
                            <option value="">Todos</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Gerar Relatório</button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection