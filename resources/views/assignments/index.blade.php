{{-- resources/views/assignments/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    <div class="row">
        <!-- Formulário de Atribuição -->
        <div class="col-md-4">
            <div class="card border-0 rounded-3 shadow-sm">
                <div class="card-header bg-light py-2">
                    <h3 class="card-title fs-5 mb-0">Nova Atribuição</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('assignments.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="employee_id" class="form-label small text-muted">Funcionário</label>
                                    <select name="employee_id" id="employee_id" class="form-select form-select-sm" required>
                                        <option value="">Selecione o funcionário...</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">
                                                {{ $employee->name }} - {{ $employee->costCenter->code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="equipment_type" class="form-label small text-muted">Tipo de Equipamento</label>
                                    <select name="equipment_type" id="equipment_type" class="form-select form-select-sm" required>
                                        <option value="">Selecione o tipo...</option>
                                        @foreach($equipmentTypes as $type)
                                            <option value="{{ $type }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="equipment_id" class="form-label small text-muted">Equipamento</label>
                                    <select name="equipment_id" id="equipment_id" class="form-select form-select-sm" required>
                                        <option value="">Selecione o tipo primeiro...</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="assignment_date" class="form-label small text-muted">Data de Atribuição</label>
                                    <input type="date" name="assignment_date" id="assignment_date" 
                                        class="form-control form-control-sm" required value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="bi bi-link me-1"></i> Registrar Atribuição
                                </button>
                                <button type="reset" class="btn btn-light btn-sm">
                                    <i class="bi bi-x-circle me-1"></i> Cancelar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Tabela de Atribuições -->
        <div class="col-md-8">
            <div class="card border-0 rounded-3 shadow">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Atribuições Realizadas</h3>
                    <div class="input-group" style="width: 250px;">
                        <input type="text" class="form-control" id="searchAssignment" placeholder="Buscar atribuição...">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="assignmentTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Funcionário</th>
                                    <th>Equipamento</th>
                                    <th>Patrimônio</th>
                                    <th>Data de Atribuição</th>
                                    <th>Centro de Custo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignmentHistory ?? [] as $assignment)
                                    <tr>
                                        <td>{{ $assignment->employee->name }}</td>
                                        <td>{{ $assignment->equipment->gadgetModel->brand }} {{ $assignment->equipment->gadgetModel->model }}</td>
                                        <td>{{ $assignment->equipment->patrimony }}</td>
                                        <td>{{ date('d/m/Y', strtotime($assignment->assignment_date)) }}</td>
                                        <td>{{ $assignment->employee->costCenter->code }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Script para filtrar equipamentos por tipo
            const typeSelect = document.getElementById('equipment_type');
            const equipmentSelect = document.getElementById('equipment_id');
            const availableEquipment = @json($availableEquipment);
        
            typeSelect.addEventListener('change', function() {
                const selectedType = this.value;
                equipmentSelect.innerHTML = '<option value="">Selecione o equipamento...</option>';
        
                if(selectedType) {
                    const filteredEquipment = availableEquipment.filter(
                        eq => eq.gadget_model.type === selectedType
                    );
        
                    filteredEquipment.forEach(eq => {
                        const option = document.createElement('option');
                        option.value = eq.id;
                        option.textContent = `${eq.gadget_model.brand} ${eq.gadget_model.model} - Patrimônio: ${eq.patrimony}`;
                        equipmentSelect.appendChild(option);
                    });
                }
            });

            // Script para busca na tabela de atribuições
            const searchInput = document.getElementById('searchAssignment');
            
            if (searchInput) {
                const table = document.getElementById('assignmentTable');
                const tableRows = table.querySelectorAll('tbody tr');
                
                function filterTable() {
                    const searchTerm = searchInput.value.toLowerCase().trim();
                    
                    tableRows.forEach(row => {
                        let found = false;
                        // Buscar em cada célula da linha (exceto a última que contém botões)
                        const cells = row.querySelectorAll('td:not(:last-child)');
                        
                        cells.forEach(cell => {
                            if (cell.textContent.toLowerCase().includes(searchTerm)) {
                                found = true;
                            }
                        });
                        
                        row.style.display = found ? '' : 'none';
                    });
                }
                
                // Adicionar eventos
                searchInput.addEventListener('input', filterTable);
                searchInput.addEventListener('keyup', filterTable);
                searchInput.addEventListener('search', filterTable);
            }
        });
    </script>
@endpush
@endsection