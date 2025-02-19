<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::count();
        $totalEquipment = Equipment::count();
        $availableEquipment = Equipment::where('is_available', true)->count();
        $activeAssignments = Assignment::whereNull('return_date')->count();
        
        $recentAssignments = Assignment::with(['employee', 'equipment'])
            ->whereNull('return_date')
            ->latest('assignment_date')
            ->take(5)
            ->get();

        $equipmentByCostCenter = DB::table('assignments')
            ->join('employees', 'assignments.employee_id', '=', 'employees.id')
            ->join('cost_centers', 'employees.cost_center_id', '=', 'cost_centers.id')
            ->whereNull('assignments.return_date')
            ->select('cost_centers.description', DB::raw('count(*) as total'))
            ->groupBy('cost_centers.description')
            ->get();

        return view('dashboard', compact(
            'totalEmployees',
            'totalEquipment',
            'availableEquipment',
            'activeAssignments',
            'recentAssignments',
            'equipmentByCostCenter'
        ));
    }

}
