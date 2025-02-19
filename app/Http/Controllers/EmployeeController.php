<?php

namespace App\Http\Controllers;

use App\Models\CostCenter;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('costCenter')->get();
        $costCenters = CostCenter::all();
        return view('employees.index', compact('employees', 'costCenters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees',
            'cpf' => 'required|string|unique:employees',
            'birth_date' => 'required|date',
            'cost_center_id' => 'required|exists:cost_centers,id'
        ]);

        Employee::create($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Funcionário cadastrado com sucesso!');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')
            ->with('success', 'Funcionário removido com sucesso!');
    }
}

