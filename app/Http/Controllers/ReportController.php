<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Equipment;
use App\Models\GadgetModel;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        $equipment = Equipment::all();
        return view('reports.index', compact('employees', 'equipment'));
    }

    public function equipmentReport(Request $request)
    {
        $query = Equipment::with(['gadgetModel', 'assignments.employee']);

        if ($request->filled('is_available')) {
            $query->where('is_available', $request->is_available);
        }
    
        // Define quantos itens você quer por página (ex: 10)
        $equipment = $query->paginate(10);
    
        return view('reports.equipment', compact('equipment'));
    }

    public function showEquipmentReport()
    {
        // $equipment = Equipment::all();
        // $equipment = $equipment->paginate(10);

        return view('equipment.report');
    }

    public function employeeReport(Request $request)
    {
        $query = Employee::query();

        if ($request->filled('employee_id')) {
            $query->where('id', $request->employee_id);
        }

        $employees = $query->with(['assignments.equipment', 'costCenter'])->paginate(10);

        return view('reports.employees', compact('employees'));
    }

    public function showEmployeeReport()
    {
        $employees = Employee::all();

        return view('employees.report', compact('employees'));
    }

    public function assignmentReport(Request $request)
    {
        $query = Assignment::with(['employee', 'equipment']);

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('equipment_type')) {
            $query->whereHas('equipment.gadgetModel', function($q) use ($request) {
                $q->where('type', $request->equipment_type);
            });
        }

        if ($request->filled('equipment_id')) {
            $query->where('equipment_id', $request->equipment_id);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereNull('return_date');
            } elseif ($request->status === 'returned') {
                $query->whereNotNull('return_date');
            }
        }

        if ($request->filled('date_start')) {
            $query->where('assignment_date', '>=', $request->date_start);
        }

        if ($request->filled('date_end')) {
            $query->where('assignment_date', '<=', $request->date_end);
        }

        $assignments = $query->orderBy('assignment_date', 'desc')->paginate(10);

        return view('reports.assignments', compact('assignments'));
    }

    public function showAssignmentReport()
    {
        $assignments = Assignment::all();
        $employees = Employee::all();
        $equipment = Equipment::all();
        $equipmentTypes = GadgetModel::select('type')
        ->distinct()
        ->pluck('type');
        

        return view('assignments.report', compact('assignments', 'employees', 'equipment', 'equipmentTypes'));
    }
}
