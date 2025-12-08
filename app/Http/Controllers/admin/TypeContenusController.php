<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TypeContenu;

class TypeContenusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         $typeContenus = TypeContenu::all();
        return view('admin.typeContenus.index', compact('typeContenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.typeContenus.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nom' => 'required|string|max:255',

        ]);

        TypeContenu::create($request->only('nom'));

        return redirect()->route('typeContenus.index')->with('success', 'Type de contenu ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $typeContenu = TypeContenu::findOrFail($id);

        return response()->json([
            'nom' => $typeContenu->nom,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
         $typeContenu = TypeContenu::findOrFail($id);
        return view('admin.typeContenus.edit', compact('typeContenu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'nom' => 'required|string|max:255',

        ]);

        $typeContenu = TypeContenu::findOrFail($id);
        $typeContenu->update($request->only('nom'));

        return redirect()->route('typeContenus.index')
                         ->with('success', 'Type de contenu modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $typeContenu = TypeContenu::findOrFail($id);
            $typeContenu->delete();

            return redirect()->route('typeContenus.index')
                             ->with('success', 'Type de média supprimé avec succès.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('typeContenus.index')
                             ->with('error', 'TypeContenu non trouvé.');
        } catch (\Throwable $e) {
            \Log::error('Erreur delete typeContenu: ' . $e->getMessage());
            return redirect()->route('typeContenus.index')
                             ->with('error', 'Erreur serveur.');
        }
    }
}
