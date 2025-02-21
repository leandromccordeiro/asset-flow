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
