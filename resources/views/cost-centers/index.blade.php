{{-- resources/views/cost-centers/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2>Cadastro de Centro de Custos</h2>
        </div>
        <div class="card-body">
            <!-- Formulário de Cadastro -->
            <div class="mb-4">
                <form action="{{ route('cost-centers.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="code" class="form-label small text-muted">Código</label>
                                <input type="text" name="code" id="code" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="description" class="form-label small text-muted">Descrição</label>
                                <input type="text" name="description" id="description" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-success btn-sm px-4">
                                <i class="bi bi-check-circle me-1"></i> Cadastrar
                            </button>
                            <button type="reset" class="btn btn-light btn-sm px-4">
                                <i class="bi bi-x-circle me-1"></i> Limpar
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabela de Centros de Custo -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="h5 mb-0">Centros de Custo Cadastrados</h3>
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" id="searchCostCenter" class="form-control" placeholder="Buscar centro de custo...">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Código</th>
                                <th>Descrição</th>
                                <th>Total de Funcionários</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($costCenters as $center)
                                <tr>
                                    <td>{{ $center->code }}</td>
                                    <td>{{ $center->description }}</td>
                                    <td>{{ $center->employees_count }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary edit-center" 
                                                    data-id="{{ $center->id }}"
                                                    data-code="{{ $center->code }}"
                                                    data-description="{{ $center->description }}">
                                                <i class="bi bi-pencil"></i> Editar
                                            </button>
                                            <form action="{{ route('cost-centers.destroy', $center) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Tem certeza que deseja excluir?')">
                                                    <i class="bi bi-trash"></i> Excluir
                                                </button>
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

<!-- Modal de Edição de Centro de Custo -->
<div class="modal fade" id="editCostCenterModal" tabindex="-1" aria-labelledby="editCostCenterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCostCenterModalLabel">Editar Centro de Custo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="editCostCenterForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_code" class="form-label">Código</label>
                        <input type="text" class="form-control" id="edit_code" name="code" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Descrição</label>
                        <input type="text" class="form-control" id="edit_description" name="description" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="editCostCenterForm" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('load', function() {
            // Configuração da busca na tabela
            const searchInput = document.getElementById('searchCostCenter');
            
            if (searchInput) {
                const tableRows = document.querySelectorAll('.table tbody tr');
                
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
                
                searchInput.addEventListener('input', filterTable);
                searchInput.addEventListener('keyup', filterTable);
                searchInput.addEventListener('search', filterTable);
            }

            // Configurar modal de edição
            const editButtons = document.querySelectorAll('.edit-center');
            const editForm = document.getElementById('editCostCenterForm');
            const modal = new bootstrap.Modal(document.getElementById('editCostCenterModal'));
            
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const centerId = this.getAttribute('data-id');
                    const code = this.getAttribute('data-code');
                    const description = this.getAttribute('data-description');
                    
                    // Preencher o formulário
                    document.getElementById('edit_code').value = code;
                    document.getElementById('edit_description').value = description;
                    
                    // Definir a URL do formulário
                    editForm.action = `/cost-centers/${centerId}`;
                    
                    // Abrir o modal
                    modal.show();
                });
            });
        });
    </script>
@endpush
@endsection