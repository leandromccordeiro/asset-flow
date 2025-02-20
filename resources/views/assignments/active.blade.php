@extends('layouts.app')

@section('content')

<div class="mt-4">
    <h3>Atribuições Ativas</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Funcionário</th>
                <th>Centro de Custo</th>
                <th>Equipamento</th>
                <th>Data de Atribuição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activeAssignments as $assignment)
                <tr>
                    <td>{{ $assignment->employee->name }}</td>
                    <td>{{ $assignment->employee->costCenter->code }}</td>
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
                    <td>
                        <form action="{{ route('assignments.return', $assignment) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="return_date" value="{{ date('Y-m-d') }}">
                            <button type="submit" class="btn btn-warning btn-sm">
                                Registrar Devolução
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection