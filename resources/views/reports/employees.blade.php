{{-- resources/views/reports/employees.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2>Relatório de Funcionários</h2>
        <a href="{{ route('employees.report') }}" class="btn btn-secondary">Voltar</a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Patrimônio</th>
                    <th>Centro de Custo</th>
                    <th>Equipamentos Atuais</th>
                    <th>Total de Atribuições</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>
                        @foreach($employee->assignments->whereNull('return_date') as $assignment)
                            {{ $assignment->equipment->patrimony }}<br>
                        @endforeach
                    </td>
                    <td>{{ $employee->costCenter->description }}</td>
                    <td>
                        @foreach($employee->assignments->whereNull('return_date') as $assignment)
                            <div class="mb-2">
                                <strong>{{ $assignment->equipment->gadgetModel->type }}</strong><br>
                                {{ $assignment->equipment->gadgetModel->brand }} 
                                {{ $assignment->equipment->gadgetModel->model }}<br>
                                <small class="text-muted">
                                    Desde: {{ $assignment->assignment_date->format('d/m/Y') }}
                                </small>
                            </div>
                        @endforeach
                        @if($employee->assignments->whereNull('return_date')->isEmpty())
                            <span class="text-muted">Nenhum equipamento atribuído</span>
                        @endif
                    </td>
                    <td>{{ $employee->assignments->count() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-3">
        {!! $employees->links() !!}
    </div>
</div>
@endsection