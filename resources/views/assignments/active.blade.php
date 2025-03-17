@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
            <h3 class="card-title fs-5 mb-0">Atribuições Ativas</h3>
            <div class="input-group" style="width: 250px;">
                <input type="text" class="form-control form-control-sm" id="searchAssignment" placeholder="Buscar atribuição...">
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
                                    <button type="button" class="btn btn-warning btn-sm open-return-modal" 
                                            data-assignment-id="{{ $assignment->id }}">
                                        <i class="bi bi-arrow-return-left me-1"></i>Registrar Devolução
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-3">
                {!! $activeAssignments->links() !!}
            </div>
        </div>
    </div>
</div>

<!-- Modal para Devolução (Um único modal reutilizável) -->
<div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="returnModalLabel">Registrar Devolução de Equipamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div id="equipmentDetails"></div>
                
                <form action="" method="POST" id="returnForm">
                    @csrf
                    @method('PATCH')
                    <div class="form-group mt-3">
                        <label for="return_date" class="form-label">Data de Devolução:</label>
                        <input type="date" name="return_date" id="return_date" 
                            class="form-control form-control-sm" required value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group mt-3">
                        <label for="return_condition" class="form-label">Condição do Equipamento:</label>
                        <select name="return_condition" id="return_condition" class="form-select form-select-sm" required>
                            <option value="good">Bom estado</option>
                            <option value="damaged">Danificado</option>
                            <option value="defective">Defeituoso</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="return_notes" class="form-label">Observações:</label>
                        <textarea name="return_notes" id="return_notes" 
                                class="form-control form-control-sm" rows="2"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="returnForm" class="btn btn-warning btn-sm">
                    Confirmar Devolução
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Script para busca na tabela
            const searchInput = document.getElementById('searchAssignment');
            
            if (searchInput) {
                const tableRows = document.querySelectorAll('#assignmentTable tbody tr');
                
                function filterTable() {
                    const searchTerm = searchInput.value.toLowerCase().trim();
                    
                    tableRows.forEach(row => {
                        let found = false;
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
            }
            
            // Setup do modal de devolução
            const modalTriggerButtons = document.querySelectorAll('.open-return-modal');
            const returnForm = document.getElementById('returnForm');
            const equipmentDetails = document.getElementById('equipmentDetails');
            const returnModal = new bootstrap.Modal('#returnModal');
            
            // Dados dos equipamentos e atribuições
            const assignments = {
                @foreach($activeAssignments as $assignment)
                {{ $assignment->id }}: {
                    id: {{ $assignment->id }},
                    employee: "{{ $assignment->employee->name }}",
                    equipment: "{{ $assignment->equipment->gadgetModel->brand }} {{ $assignment->equipment->gadgetModel->model }}",
                    patrimony: "{{ $assignment->equipment->patrimony }}",
                    returnRoute: "{{ route('assignments.return', $assignment) }}"
                },
                @endforeach
            };
            
            // Configurar eventos de clique nos botões
            modalTriggerButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const assignmentId = this.getAttribute('data-assignment-id');
                    const assignment = assignments[assignmentId];
                    
                    if (assignment) {
                        // Atualizar detalhes no modal
                        equipmentDetails.innerHTML = `
                            <p>Confirmar a devolução do equipamento:</p>
                            <div class="mb-2">
                                <strong>Equipamento:</strong> ${assignment.equipment}
                            </div>
                            <div class="mb-2">
                                <strong>Patrimônio:</strong> ${assignment.patrimony}
                            </div>
                            <div class="mb-2">
                                <strong>Funcionário:</strong> ${assignment.employee}
                            </div>
                        `;
                        
                        // Atualizar ação do formulário
                        returnForm.action = assignment.returnRoute;
                        
                        // Abrir o modal
                        returnModal.show();
                    }
                });
            });
        });
    </script>
@endpush
@endsection