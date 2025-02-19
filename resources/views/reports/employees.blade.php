{{-- resources/views/reports/employees.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2>Relatório de Funcionários</h2>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>CPF</th>
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
                    <td>{{ $employee->cpf }}</td>
                    <td>{{ $employee->costCenter->description }}</td>
                    <td>
                        @foreach($employee->assignments->whereNull('return_date') as $assignment)
                            <div>
                                {{ $assignment->equipment->model }} 
                                ({{ $assignment->equipment->patrimony }})
                            </div>
                        @endforeach
                    </td>
                    <td>{{ $employee->assignments->count() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection