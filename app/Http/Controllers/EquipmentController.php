<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\GadgetModel;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::with('gadgetModel')->orderBy('patrimony')->get();
        $gadgetModels = GadgetModel::all();
        return view('equipment.index', compact('equipments', 'gadgetModels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gadget_model_id' => 'required|exists:gadget_models,id',
            'patrimony' => 'required|string|unique:equipments',
            'purchase_date' => 'required|date'
        ]);

        Equipment::create($validated);

        return redirect()->route('equipment.index')
            ->with('success', 'Equipamento cadastrado com sucesso!');
    }

    public function destroy(Equipment $equipment)
    {
        if ($equipment->assignments()->whereNull('return_date')->exists()) {
            return redirect()->route('equipment.index')
                ->with('error', 'Não é possível excluir um equipamento que está em uso.');
        }

        $equipment->delete();
        return redirect()->route('equipment.index')
            ->with('success', 'Equipamento removido com sucesso!');
    }
}
