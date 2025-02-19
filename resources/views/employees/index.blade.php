{{-- resources/views/employees/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Cadastro de Funcionários</h2>
    
    <form action="{{ route('employees.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="cpf">CPF</label>
            <input type="text" name="cpf" id="cpf" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="birth_date">Data de Nascimento</label>
            <input type="date" name="birth_date" id="birth_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="cost_center_id">Centro de Custo</label>
            <select name="cost_center_id" id="cost_center_id" class="form-control" required>
                <option value="">Selecione...</option>
                @foreach($costCenters as $center)
                    <option value="{{ $center->id }}">{{ $center->code }} - {{ $center->description }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

    <div class="mt-4">
        <h3>Funcionários Cadastrados</h3>
        <table class="table">
            <thead>
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
                            <form action="{{ route('employees.destroy', $employee) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection