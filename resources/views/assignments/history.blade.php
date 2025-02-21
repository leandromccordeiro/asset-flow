@extends('layouts.app')

@section('content')
<div class="mt-4">
    <h3>Histórico de Atribuições</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Funcionário</th>
                <th>Equipamento</th>
                <th>Data de Atribuição</th>
                <th>Data de Devolução</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignmentHistory as $assignment)
                <tr>
                    <td>{{ $assignment->employee->name }}</td>
                    <td>
                        <div>
                            <strong>{{ $assignment->equipment->gadgetModel->brand }} 
                                    {{ $assignment->equipment->gadgetModel->model }}</strong>
                        </div>
                        <small class="text-muted">
                            Tipo: {{ $assignment->equipment->gadgetModel->type }}<br>
                            Patrimônio: {{ $assignment->equipment->patrimony }}
                        </small>
                    </td>
                    <td>{{ $assignment->assignment_date->format('d/m/Y') }}</td>
                    <td>{{ $assignment->return_date ? $assignment->return_date->format('d/m/Y') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
@endsection