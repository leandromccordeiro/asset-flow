{{-- resources/views/assignments/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="card">
    <h2 class="h2 text-center">Atribuições de Equipamentos</h2>
    
    <form action="{{ route('assignments.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="form-group">
            <label for="employee_id">Funcionário</label>
            <select name="employee_id" id="employee_id" class="form-control" required>
                <option value="">Selecione o funcionário...</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">
                        {{ $employee->name }} - {{ $employee->costCenter->code }}
                    </option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group">
            <label for="equipment_type">Tipo de Equipamento</label>
            <select name="equipment_type" id="equipment_type" class="form-control" required>
                <option value="">Selecione o tipo...</option>
                @foreach($equipmentTypes as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group">
            <label for="equipment_id">Equipamento</label>
            <select name="equipment_id" id="equipment_id" class="form-control" required>
                <option value="">Selecione o tipo primeiro...</option>
            </select>
        </div>
    
        <div class="form-group">
            <label for="assignment_date">Data de Atribuição</label>
            <input type="date" name="assignment_date" id="assignment_date" 
                   class="form-control" required value="{{ date('Y-m-d') }}">
        </div>
    
        <button type="submit" class="btn btn-primary">Registrar Atribuição</button>
    </form>


    <div class="mt-4">
        <h3>Histórico de Atribuições</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Funcionário</th>
                    <th>Equipamento</th>
                    <th>Data de Atribuição</th>
                    <th>Data de Devolução</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assignmentHistory as $assignment)
                    <tr>
                        <td>{{ $assignment->employee->name }}</td>
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
                        <td>{{ $assignment->return_date ? $assignment->return_date->format('d/m/Y') : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
    });
    </script>
@endsection
