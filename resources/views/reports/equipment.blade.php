{{-- resources/views/reports/equipment.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2>Relatório de Equipamentos</h2>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Patrimônio</th>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Data de Compra</th>
                    <th>Status</th>
                    <th>Usuário Atual</th>
                </tr>
            </thead>
            <tbody>
                @foreach($equipment as $item)
                <tr>
                    <td>{{ $item->patrimony }}</td>
                    <td>{{ $item->model }}</td>
                    <td>{{ $item->brand }}</td>
                    <td>{{ $item->purchase_date->format('d/m/Y') }}</td>
                    <td>{{ $item->is_available ? 'Disponível' : 'Em uso' }}</td>
                    <td>
                        @if(!$item->is_available)
                            {{ $item->assignments->whereNull('return_date')->first()->employee->name ?? 'N/A' }}
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