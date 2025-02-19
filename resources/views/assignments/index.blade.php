{{-- resources/views/assignments/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Atribuições de Equipamentos</h2>
    
    <form action="{{ route('assignments.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="form-group">
            <label for="employee_id">Funcionário</label>
            <select name="employee_id" id="employee_id" class="form-control" required>
                <option value="">Selecione o funcionário...</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">
                        {{ $employee->name }} - {{ $employee->costCenter->code }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="equipment_id">Equipamento</label>
            <select name="equipment_id" id="equipment_id" class="form-control" required>
                <option value="">Selecione o equipamento...</option>
                @foreach($availableEquipment as $equipment)
                    <option value="{{ $equipment->id }}">
                        {{ $equipment->model }} - Patrimônio: {{ $equipment->patrimony }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="assignment_date">Data de Atribuição</label>
            <input type="date" name="assignment_date" id="assignment_date" 
                   class="form-control" required value="{{ date('Y-m-d') }}">
        </div>

        <button type="submit" class="btn btn-primary">Registrar Atribuição</button>
    </form>

    <div class="mt-4">
        <h3>Atribuições Ativas</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Funcionário</th>
                    <th>Equipamento</th>
                    <th>Data de Atribuição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activeAssignments as $assignment)
                    <tr>
                        <td>
                            {{ $assignment->employee->name }}
                            <br>
                            <small class="text-muted">
                                {{ $assignment->employee->costCenter->code }}
                            </small>
                        </td>
                        <td>
                            {{ $assignment->equipment->model }}
                            <br>
                            <small class="text-muted">
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
                        <td>{{ $assignment->equipment->model }}</td>
                        <td>{{ $assignment->assignment_date->format('d/m/Y') }}</td>
                        <td>{{ $assignment->return_date ? $assignment->return_date->format('d/m/Y') : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection