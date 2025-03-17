{{-- resources/views/gadget-models/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2>Cadastro de Modelos de Equipamento</h2>
        </div>
        <div class="card-body">
            <!-- Formulário de Cadastro -->
            <div class="mb-4">
                <form action="{{ route('gadget-models.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="type" class="form-label small text-muted">Tipo</label>
                                <input type="text" name="type" id="type" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="brand" class="form-label small text-muted">Marca</label>
                                <input type="text" name="brand" id="brand" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="model" class="form-label small text-muted">Modelo</label>
                                <input type="text" name="model" id="model" class="form-control form-control-sm" required>
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

            <!-- Tabela de Modelos Cadastrados -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="h5 mb-0">Modelos Cadastrados</h3>
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" id="searchGadgetModel" class="form-control" placeholder="Buscar modelo...">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tipo</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gadgetModels as $model)
                                <tr>
                                    <td>{{ $model->type }}</td>
                                    <td>{{ $model->brand }}</td>
                                    <td>{{ $model->model }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary edit-model" 
                                                    data-id="{{ $model->id }}"
                                                    data-type="{{ $model->type }}"
                                                    data-brand="{{ $model->brand }}"
                                                    data-model="{{ $model->model }}">
                                                <i class="bi bi-pencil"></i> Editar
                                            </button>
                                            <form action="{{ route('gadget-models.destroy', $model) }}" method="POST">
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

<!-- Modal de Edição de Modelo -->
<div class="modal fade" id="editModelModal" tabindex="-1" aria-labelledby="editModelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModelModalLabel">Editar Modelo de Equipamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="editModelForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_type" class="form-label">Tipo</label>
                        <input type="text" class="form-control" id="edit_type" name="type" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_brand" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="edit_brand" name="brand" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_model" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="edit_model" name="model" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="editModelForm" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('load', function() {
            // Configuração da busca na tabela
            const searchInput = document.getElementById('searchGadgetModel');
            
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
            const editButtons = document.querySelectorAll('.edit-model');
            const editForm = document.getElementById('editModelForm');
            const modal = new bootstrap.Modal(document.getElementById('editModelModal'));
            
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const modelId = this.getAttribute('data-id');
                    const type = this.getAttribute('data-type');
                    const brand = this.getAttribute('data-brand');
                    const modelName = this.getAttribute('data-model');
                    
                    // Preencher o formulário
                    document.getElementById('edit_type').value = type;
                    document.getElementById('edit_brand').value = brand;
                    document.getElementById('edit_model').value = modelName;
                    
                    // Definir a URL do formulário
                    editForm.action = `/gadget-models/${modelId}`;
                    
                    // Abrir o modal
                    modal.show();
                });
            });
        });
    </script>
@endpush
@endsection