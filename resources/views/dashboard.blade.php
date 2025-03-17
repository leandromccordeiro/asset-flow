{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="dashboard">
    {{-- Cards Informativos --}}
    <div class="grid-cards">
        <div class="card info-card">
            <div class="card-icon employees">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-content">
                <h3 class="text-center">Funcionários</h3>
                <p class="number text-center">{{ $totalEmployees }}</p>
            </div>
        </div>

        <div class="card info-card">
            <div class="card-icon equipment">
                <i class="fas fa-laptop"></i>
            </div>
            <div class="card-content">
                <h3 class="text-center">Equipamentos</h3>
                <p class="number text-center">{{ $totalEquipment }}</p>
                <p class="sub-info text-center text-danger">{{ $availableEquipment }} disponíveis</p>
            </div>
        </div>

        <div class="card info-card">
            <div class="card-icon assignments">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div class="card-content text-center">
                <h3 class="text-center">Atribuições Ativas</h3>
                <p class="number text-center">{{ $activeAssignments }}</p>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        {{-- Atribuições Recentes --}}
        <div class="card recent-assignments">
            <div class="card-header">
                <h3>Atribuições Recentes</h3>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Funcionário</th>
                            <th>Equipamento</th>
                            <th>Data</th>
                            <th>Centro de Custo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentAssignments as $assignment)
                            <tr>
                                <td>{{ $assignment->employee->name }}</td>
                                <td>{{ $assignment->equipment->model }} ({{ $assignment->equipment->patrimony }})</td>
                                <td>{{ $assignment->assignment_date->format('d/m/Y') }}</td>
                                <td>{{ $assignment->employee->costCenter->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="ard cost-center-distribution">
            <div class="">
                <div class="card">
                    <div class="card-header">
                        <h3>Equipamentos Disponíveis por Tipo</h3>
                    </div>
                    <br>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th class='text-center'>Quantidade Disponível</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($availableByType as $type)
                                        <tr>
                                            <td>{{ $type->type }}</td>
                                            <td class='text-center'>
                                                <span class="badge bg-success">{{ $type->total }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($availableByType->isEmpty())
                                        <tr>
                                            <td colspan="2" class="text-center">
                                                Nenhum equipamento disponível
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th class='text-center'>{{ $availableEquipment }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                </div>
            </div>
        </div>

        {{-- Distribuição por Centro de Custo --}}
        {{-- <div class="card cost-center-distribution">
            <h2>Equipamentos por Centro de Custo</h2>
            <div class="chart-container">
                <div class="chart-wrapper">
                    @foreach($equipmentByCostCenter as $center)
                        <div class="chart-bar">
                            <div class="bar-label">{{ $center->description }}</div>
                            <div class="bar" style="height: {{ ($center->total / $activeAssignments) * 100 }}%">
                                <span class="bar-value">{{ $center->total }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div> --}}
    </div>
</div>

<style>
    .dashboard {
        padding: 20px;
    }

    .grid-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .info-card {
        display: flex;
        align-items: center;
        padding: 20px;
        border-radius: 8px;
        background: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .card-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 24px;
    }

    .employees {
        background: #e3f2fd;
        color: #1976d2;
    }

    .equipment {
        background: #e8f5e9;
        color: #388e3c;
    }

    .assignments {
        background: #fff3e0;
        color: #f57c00;
    }

    .card-content h3 {
        margin: 0;
        font-size: 16px;
        color: #666;
    }

    .number {
        font-size: 24px;
        font-weight: bold;
        margin: 5px 0;
        color: #333;
    }

    .sub-info {
        font-size: 14px;
        color: #666;
    }

    .dashboard-content {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    .card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .card h2 {
        margin-bottom: 20px;
        color: #333;
        font-size: 18px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .table th {
        font-weight: 600;
        color: #666;
    }

    .chart-container {
        height: 300px;
        padding: 20px 0;
    }

    .chart-wrapper {
        display: flex;
        align-items: flex-end;
        height: 100%;
        gap: 15px;
    }

    .chart-bar {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .bar {
        width: 40px;
        background: #1976d2;
        border-radius: 4px 4px 0 0;
        position: relative;
        transition: height 0.3s;
        min-height: 30px;
    }

    .bar-value {
        position: absolute;
        top: -25px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 14px;
        font-weight: bold;
    }

    .bar-label {
        margin-top: 10px;
        font-size: 12px;
        color: #666;
        text-align: center;
        word-wrap: break-word;
        max-width: 80px;
    }

    @media (max-width: 768px) {
        .dashboard-content {
            grid-template-columns: 1fr;
        }
        
        .grid-cards {
            grid-template-columns: 1fr;
        }
    }
</style>

@endsection