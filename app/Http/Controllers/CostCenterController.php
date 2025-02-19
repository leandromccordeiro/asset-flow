<?php

namespace App\Http\Controllers;

use App\Models\CostCenter;
use Illuminate\Http\Request;

class CostCenterController extends Controller
{
    public function index()
    {
        $costCenters = CostCenter::withCount('employees')->get();
        return view('cost-centers.index', compact('costCenters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:cost_centers',
            'description' => 'required|string|max:255'
        ]);

        CostCenter::create($validated);

        return redirect()->route('cost-centers.index')
            ->with('success', 'Centro de Custo cadastrado com sucesso!');
    }

    public function destroy(CostCenter $costCenter)
    {
        if ($costCenter->employees()->exists()) {
            return redirect()->route('cost-centers.index')
                ->with('error', 'Não é possível excluir um centro de custo com funcionários vinculados.');
        }

        $costCenter->delete();
        return redirect()->route('cost-centers.index')
            ->with('success', 'Centro de Custo removido com sucesso!');
    }
}
