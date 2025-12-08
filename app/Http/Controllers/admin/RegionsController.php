<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;

class RegionsController extends Controller
{
    public function index()
    {
        $regions = Region::all();
        return view('admin.regions.index', compact('regions'));
    }

    public function create()
    {
        return view('admin.regions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'localisation' => 'nullable|string',
            'population' => 'nullable|integer',
            'superficie' => 'nullable|numeric',
        ]);

        Region::create($request->only('nom','description','localisation','population','superficie'));

        return redirect()->route('regions.index')->with('success', 'Région ajoutée avec succès.');
    }

    public function show(string $id)
    {
        $region = Region::findOrFail($id);

        return response()->json([
            'nom' => $region->nom,
            'description' => $region->description,
            'localisation' => $region->localisation,
            'population' => $region->population,
            'superficie' => $region->superficie,
        ]);
    }

    public function edit(string $id)
    {
        $region = Region::findOrFail($id);
        return view('admin.regions.edit', compact('region'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'localisation' => 'nullable|string',
            'population' => 'nullable|integer',
            'superficie' => 'nullable|numeric',
        ]);

        $region = Region::findOrFail($id);
        $region->update($request->only('nom','description','localisation','population','superficie'));

        return redirect()->route('regions.index')
                         ->with('success', 'Région modifiée avec succès.');
    }

    public function destroy(string $id)
    {
        try {
            $region = Region::findOrFail($id);
            $region->delete();

            return redirect()->route('regions.index')
                             ->with('success', 'Région supprimée avec succès.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('regions.index')
                             ->with('error', 'Région non trouvée.');
        } catch (\Throwable $e) {
            \Log::error('Erreur delete region: ' . $e->getMessage());
            return redirect()->route('regions.index')
                             ->with('error', 'Erreur serveur.');
        }
    }
}
