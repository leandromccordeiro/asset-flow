<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignmentRequest;
use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Equipment;
use App\Models\GadgetModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    public function index()
    {
        $employees = Employee::with('costCenter')->get();
        $availableEquipment = Equipment::with('gadgetModel')
                                ->where('is_available', true)
                                ->get();
        $equipmentTypes = GadgetModel::select('type')
                                ->distinct()
                                ->pluck('type');
        $activeAssignments = Assignment::with(['employee.costCenter', 'equipment.gadgetModel'])
                                ->whereNull('return_date')
                                ->get();
        $assignmentHistory = Assignment::with(['employee', 'equipment.gadgetModel'])
                                ->whereNotNull('return_date')
                                ->latest()
                                ->take(10)
                                ->get();
    
        return view('assignments.index', compact(
            'employees',
            'availableEquipment',
            'equipmentTypes',
            'activeAssignments',
            'assignmentHistory'
        ));
    }

    public function store(AssignmentRequest $request)
    {   
        $validated = $request->validated();

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

    public function active()
    {
        $activeAssignments = Assignment::with(['employee.costCenter', 'equipment.gadgetModel'])
                                ->whereNull('return_date')
                                ->paginate(10);
    
        return view('assignments.active', compact('activeAssignments'));

    }

    public function history() {
        $assignmentHistory = Assignment::with(['employee', 'equipment.gadgetModel'])
                                ->whereNotNull('return_date')
                                ->latest()
                                ->paginate(10);
    
        return view('assignments.history', compact('assignmentHistory'));
    }
}
