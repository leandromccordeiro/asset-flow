@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    <div class="col-md-12">
        <div class="card border-0 rounded-3 shadow">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Funcionários Cadastrados</h3>
                <div class="input-group" style="width: 250px;">
                    <input type="text" class="form-control" id="searchEmployee" placeholder="Buscar funcionário...">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless align-middle" id="employeeTable">
                        <thead class="bg-light">
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>CPF</th>
                                <th>Centro de Custo</th>
                                <th>Ações</th>
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
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary edit-employee" 
                                                    data-id="{{ $employee->id }}"
                                                    data-name="{{ $employee->name }}"
                                                    data-email="{{ $employee->email }}"
                                                    data-cpf="{{ $employee->cpf }}"
                                                    data-birth-date="{{ $employee->birth_date }}"
                                                    data-cost-center="{{ $employee->cost_center_id }}">
                                                Editar
                                            </button>
                                            <form action="{{ route('employees.destroy', $employee) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Edição -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmployeeModalLabel">Editar Funcionário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="editEmployeeForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="edit_cpf" name="cpf" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_birth_date" class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" id="edit_birth_date" name="birth_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_cost_center_id" class="form-label">Centro de Custo</label>
                        <select class="form-select" id="edit_cost_center_id" name="cost_center_id" required>
                            @foreach($costCenters as $center)
                                <option value="{{ $center->id }}">{{ $center->code }} - {{ $center->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="editEmployeeForm" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Script para formatação de CPF
        document.addEventListener('DOMContentLoaded', function() {
            // Formatação de CPF
            document.getElementById('edit_cpf').addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, '');
                
                if (value.length > 11) {
                    value = value.substring(0, 11);
                }
                
                value = value.replace(/^(\d{3})(\d)/, '$1.$2');
                value = value.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
                value = value.replace(/\.(\d{3})(\d)/, '.$1-$2');
                
                e.target.value = value;
            });

            // Garantir que o script seja executado após o carregamento completo da página
            const searchInput = document.getElementById('searchEmployee');
            const modal = new bootstrap.Modal(document.getElementById('editEmployeeModal'));
            
            if (searchInput) {
                // Verificar se existem linhas na tabela
                const tableRows = document.querySelectorAll('.table tbody tr');
                
                // Função de filtro
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
                
                // Adicionar eventos (keyup é mais responsivo que só input)
                searchInput.addEventListener('input', filterTable);
                searchInput.addEventListener('keyup', filterTable);
                
                // Também podemos acionar o filtro ao limpar o campo
                searchInput.addEventListener('search', filterTable);
            }
            
            // Configurar os botões de edição
            const editButtons = document.querySelectorAll('.edit-employee');
            const editForm = document.getElementById('editEmployeeForm');
            
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const employeeId = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const email = this.getAttribute('data-email');
                    const cpf = this.getAttribute('data-cpf');
                    const birthDate = this.getAttribute('data-birth-date');
                    const costCenter = this.getAttribute('data-cost-center');
                    
                    // Preencher o formulário
                    document.getElementById('edit_name').value = name;
                    document.getElementById('edit_email').value = email;
                    document.getElementById('edit_cpf').value = cpf;
                    document.getElementById('edit_birth_date').value = birthDate;
                    document.getElementById('edit_cost_center_id').value = costCenter;
                    
                    // Definir a URL do formulário
                    editForm.action = `/employees/${employeeId}`;
                    
                    // Abrir o modal
                    modal.show();
                });
            });
        });
    </script>
@endpush
@endsection