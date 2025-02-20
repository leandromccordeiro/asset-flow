{{-- resources/views/reports/equipment.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2>Relatório de Equipamentos</h2>
        <a href="{{ route('equipments.report') }}" class="btn btn-secondary">Voltar</a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Patrimônio</th>
                    <th>Tipo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Data de Compra</th>
                    <th>Status</th>
                    <th>Usuário Atual</th>
                </tr>
            </thead>
            <tbody>
                @foreach($equipment as $item)
                <tr>
                    <td>{{ $item->patrimony }}</td>
                    <td>{{ $item->gadgetModel->type }}</td>
                    <td>{{ $item->gadgetModel->brand }}</td>
                    <td>{{ $item->gadgetModel->model }}</td>
                    <td>{{ $item->purchase_date->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge {{ $item->is_available ? 'bg-success' : 'bg-danger' }}">
                            {{ $item->is_available ? 'Disponível' : 'Em uso' }}
                        </span>
                    </td>
                    <td>
                        @if(!$item->is_available)
                            @php
                                $currentAssignment = $item->assignments()
                                    ->whereNull('return_date')
                                    ->with('employee')
                                    ->first();
                            @endphp
                            @if($currentAssignment)
                                <div>
                                    <strong>{{ $currentAssignment->employee->name }}</strong><br>
                                    <small class="text-muted">
                                        Desde: {{ $currentAssignment->assignment_date->format('d/m/Y') }}
                                    </small>
                                </div>
                            @endif
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection