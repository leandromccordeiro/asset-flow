<?php

namespace App\Http\Controllers;

use App\Models\GadgetModel;
use Illuminate\Http\Request;

class GadgetModelController extends Controller
{
    public function index()
    {
        $gadgetModels = GadgetModel::orderBy('type')->get();
        return view('gadget-models.index', compact('gadgetModels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255'
        ]);

        GadgetModel::create($validated);

        return redirect()->route('gadget-models.index')
            ->with('success', 'Modelo cadastrado com sucesso!');
    }

    public function destroy(GadgetModel $gadgetModel)
    {
        if ($gadgetModel->equipment()->exists()) {
            return redirect()->route('gadget-models.index')
                ->with('error', 'Não é possível excluir um modelo que possui equipamentos vinculados.');
        }

        $gadgetModel->delete();
        return redirect()->route('gadget-models.index')
            ->with('success', 'Modelo removido com sucesso!');
    }
}
