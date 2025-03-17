{{-- resources/views/employees/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow-sm">
                <div class="card-header bg-light py-2">
                    <h3 class="card-title fs-5 mb-0">Cadastro de Funcionários</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('employees.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label small text-muted">Nome</label>
                                    <input type="text" name="name" id="name" class="form-control form-control-sm" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label small text-muted">Email</label>
                                    <input type="email" name="email" id="email" class="form-control form-control-sm" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cpf" class="form-label small text-muted">CPF</label>
                                    <input type="text" name="cpf" id="cpf" class="form-control form-control-sm" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="birth_date" class="form-label small text-muted">Data de Nascimento</label>
                                    <input type="date" name="birth_date" id="birth_date" class="form-control form-control-sm" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cost_center_id" class="form-label small text-muted">Centro de Custo</label>
                                    <select name="cost_center_id" id="cost_center_id" class="form-select form-select-sm" required>
                                        <option value="">Selecione...</option>
                                        @foreach($costCenters as $center)
                                            <option value="{{ $center->id }}">{{ $center->code }} - {{ $center->description }}</option>
                                        @endforeach
                                    </select>
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
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        // Script para formatação de CPF
        document.getElementById('cpf').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 11) {
                value = value.substring(0, 11);
            }
            
            value = value.replace(/^(\d{3})(\d)/, '$1.$2');
            value = value.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
            value = value.replace(/\.(\d{3})(\d)/, '.$1-$2');
            
            e.target.value = value;
        });
    </script>
@endpush
@endsection