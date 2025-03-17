{{-- resources/views/equipment/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-light py-2">
            <h2 class="card-title fs-5 mb-0">Cadastro de Equipamentos</h2>
        </div>
        
        <div class="card-body">
            <form action="{{ route('equipment.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="gadget_model_id" class="form-label small text-muted">Modelo</label>
                        <select name="gadget_model_id" id="gadget_model_id" class="form-select form-select-sm" required>
                            <option value="">Selecione o modelo...</option>
                            @foreach($gadgetModels->groupBy('type') as $type => $models)
                                <optgroup label="{{ $type }}">
                                    @foreach($models as $model)
                                        <option value="{{ $model->id }}">
                                            {{ $model->brand }} - {{ $model->model }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="patrimony" class="form-label small text-muted">Patrimônio</label>
                        <input type="text" name="patrimony" id="patrimony" class="form-control form-control-sm" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="purchase_date" class="form-label small text-muted">Data de Compra</label>
                        <input type="date" name="purchase_date" id="purchase_date" class="form-control form-control-sm" required>
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary btn-sm px-3">
                        <i class="bi bi-plus-circle me-1"></i>Cadastrar
                    </button>
                    <button type="reset" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Limpar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 mt-4">
        <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Equipamentos Cadastrados</h3>
            <div class="input-group" style="width: 300px;">
                <input type="text" class="form-control" id="searchEquipment" placeholder="Buscar equipamento...">
                <span class="input-group-text bg-white">
                    <i class="bi bi-search"></i>
                </span>
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Modelo</th>
                            <th>Marca</th>
                            <th>Tipo</th>
                            <th>Patrimônio</th>
                            <th>Data de Compra</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Aqui você pode adicionar um loop foreach para exibir os equipamentos 
                        Exemplo: --}}
                        @foreach($equipments as $equipment)
                            <tr>
                                <td>{{ $equipment->gadgetModel->model }}</td>
                                <td>{{ $equipment->gadgetModel->brand }}</td>
                                <td>{{ $equipment->gadgetModel->type }}</td>
                                <td>{{ $equipment->patrimony }}</td>
                                <td>{{ date('d/m/Y', strtotime($equipment->purchase_date)) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary edit-equipment" 
                                                data-id="{{ $equipment->id }}"
                                                data-gadget-model-id="{{ $equipment->gadget_model_id }}"
                                                data-patrimony="{{ $equipment->patrimony }}"
                                                data-purchase-date="{{ $equipment->purchase_date->format('Y-m-d') }}">
                                            <i class="bi bi-pencil"></i> Editar
                                        </button>
                                        <form action="{{ route('equipment.destroy', $equipment) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Confirma a exclusão deste equipamento?')">
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

<!-- Modal de Edição de Equipamento -->
<div class="modal fade" id="editEquipmentModal" tabindex="-1" aria-labelledby="editEquipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEquipmentModalLabel">Editar Equipamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="editEquipmentForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_gadget_model_id" class="form-label">Modelo</label>
                        <select name="gadget_model_id" id="edit_gadget_model_id" class="form-select" required>
                            <option value="">Selecione o modelo...</option>
                            @foreach($gadgetModels->groupBy('type') as $type => $models)
                                <optgroup label="{{ $type }}">
                                    @foreach($models as $model)
                                        <option value="{{ $model->id }}">
                                            {{ $model->brand }} - {{ $model->model }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_patrimony" class="form-label">Patrimônio</label>
                        <input type="text" class="form-control" id="edit_patrimony" name="patrimony" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_purchase_date" class="form-label">Data de Compra</label>
                        <input type="date" class="form-control" id="edit_purchase_date" name="purchase_date" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="editEquipmentForm" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Garantir que o script seja executado após o carregamento completo da página
        window.addEventListener('load', function() {
            // Configuração da busca na tabela
            const searchInput = document.getElementById('searchEquipment');
            
            if (searchInput) {
                console.log('Input de busca encontrado');
                
                // Verificar se existem linhas na tabela
                const tableRows = document.querySelectorAll('.table tbody tr');
                console.log('Número de linhas na tabela: ' + tableRows.length);
                
                // Função de filtro
                function filterTable() {
                    const searchTerm = searchInput.value.toLowerCase().trim();
                    console.log('Termo de busca: ' + searchTerm);
                    
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
                
                console.log('Eventos de busca inicializados com sucesso');
            } else {
                console.error('Elemento de busca não encontrado. ID: searchEquipment');
            }

            // Configurar modal de edição
            const editButtons = document.querySelectorAll('.edit-equipment');
            const editForm = document.getElementById('editEquipmentForm');
            const modal = new bootstrap.Modal(document.getElementById('editEquipmentModal'));
            
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const equipmentId = this.getAttribute('data-id');
                    const gadgetModelId = this.getAttribute('data-gadget-model-id');
                    const patrimony = this.getAttribute('data-patrimony');
                    const purchaseDate = this.getAttribute('data-purchase-date');
                    
                    // Preencher o formulário
                    document.getElementById('edit_gadget_model_id').value = gadgetModelId;
                    document.getElementById('edit_patrimony').value = patrimony;
                    document.getElementById('edit_purchase_date').value = purchaseDate;
                    
                    // Definir a URL do formulário
                    editForm.action = `/equipment/${equipmentId}`;
                    
                    // Abrir o modal
                    modal.show();
                });
            });
        });
    </script>
@endpush

@endsection