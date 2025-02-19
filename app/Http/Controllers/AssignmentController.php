<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    public function index()
    {
        $employees = Employee::with('costCenter')->get();
        $availableEquipment = Equipment::where('is_available', true)->get();
        $activeAssignments = Assignment::with(['employee.costCenter', 'equipment'])
            ->whereNull('return_date')
            ->get();
        $assignmentHistory = Assignment::with(['employee', 'equipment'])
            ->whereNotNull('return_date')
            ->latest('return_date')
            ->take(10)
            ->get();

        return view('assignments.index', compact(
            'employees',
            'availableEquipment',
            'activeAssignments',
            'assignmentHistory'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'equipment_id' => 'required|exists:equipment,id',
            'assignment_date' => 'required|date'
        ]);

        DB::transaction(function () use ($validated) {
            Assignment::create($validated);
            
            Equipment::where('id', $validated['equipment_id'])
                ->update(['is_available' => false]);
        });

        return redirect()->route('assignments.index')
            ->with('success', 'Atribuição registrada com sucesso!');
    }

    public function return(Assignment $assignment, Request $request)
    {
        $request->validate([
            'return_date' => 'required|date'
        ]);

        DB::transaction(function () use ($assignment, $request) {
            $assignment->update([
                'return_date' => $request->return_date
            ]);
            
            Equipment::where('id', $assignment->equipment_id)
                ->update(['is_available' => true]);
        });

        return redirect()->route('assignments.index')
            ->with('success', 'Devolução registrada com sucesso!');
    }
}
