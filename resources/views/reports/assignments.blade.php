{{-- resources/views/reports/assignments.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2>Relatório de Atribuições</h2>
        <a href="{{ route('assignments.report') }}" class="btn btn-secondary">Voltar</a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Funcionário</th>
                    <th>Centro de Custo</th>
                    <th>Equipamento</th>
                    <th>Data de Atribuição</th>
                    <th>Data de Devolução</th>
                    <th>Status</th>
                    <th>Tempo de Uso</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assignments as $assignment)
                <tr>
                    <td>
                        {{ $assignment->employee->name }}
                    </td>
                    <td>
                        {{ $assignment->employee->costCenter->description }}
                    </td>
                    <td>
                        <div>
                            <strong>Tipo: {{ $assignment->equipment->gadgetModel->type }}</strong><br>
                            {{ $assignment->equipment->gadgetModel->brand }} 
                            {{ $assignment->equipment->gadgetModel->model }}<br>
                            <small class="text-muted">
                                Patrimônio: {{ $assignment->equipment->patrimony }}
                            </small>
                        </div>
                    </td>
                    <td>{{ $assignment->assignment_date->format('d/m/Y') }}</td>
                    <td>
                        @if($assignment->return_date)
                            {{ $assignment->return_date->format('d/m/Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($assignment->return_date)
                            <span class="badge bg-success">Devolvido</span>
                        @else
                            <span class="badge bg-primary">Em uso</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $startDate = $assignment->assignment_date;
                            $endDate = $assignment->return_date ?? now();
                            $diff = $startDate->diff($endDate);
                            
                            if ($diff->y > 0) {
                                echo $diff->y . ' ano(s) ';
                            }
                            if ($diff->m > 0) {
                                echo $diff->m . ' mês(es) ';
                            }
                            echo $diff->d . ' dia(s)';
                        @endphp
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection