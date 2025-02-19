{{-- resources/views/reports/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Relatórios</h2>
        </div>
        <div class="card-body">
            <!-- Relatório de Equipamentos -->
            <div class="mb-4">
                <h3>Relatório de Equipamentos</h3>
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

            <!-- Relatório de Funcionários -->
            <div class="mb-4">
                <h3>Relatório de Funcionários</h3>
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

            <!-- Relatório de Atribuições -->
            <div class="mb-4">
                <h3>Relatório de Atribuições</h3>
                <form action="{{ route('reports.assignments') }}" method="GET" class="mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Funcionário</label>
                                <select name="employee_id" class="form-control">
                                    <option value="">Todos</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Equipamento</label>
                                <select name="equipment_id" class="form-control">
                                    <option value="">Todos</option>
                                    @foreach($equipment as $item)
                                        <option value="{{ $item->id }}">{{ $item->model }} ({{ $item->patrimony }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="">Todos</option>
                                    <option value="active">Em uso</option>
                                    <option value="returned">Devolvidos</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Data Inicial</label>
                                <input type="date" name="date_start" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Data Final</label>
                                <input type="date" name="date_end" class="form-control">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Gerar Relatório</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection