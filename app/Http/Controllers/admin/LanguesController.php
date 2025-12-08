<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Langue;

class LanguesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //affichage générale
        $langues=Langue::all();
         return view("admin.langues.index",compact('langues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //formulaire de creation de langue--bouton 'Créer'
        return view('admin.langues.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //action après soumission de formulaire
        Langue::create($request->all());
        return redirect()->route('langues.create')->with('success', 'Utilisateur créé avec succès.');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $langue = Langue::findOrFail($id);

    return response()->json([
        'code' => $langue->codeLangue,
        'nom' => $langue->nom,
        'description' => $langue->description,

    ]);
}
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //formulaire modification
         $langue = Langue::findOrFail($id);
        return view('admin.langues.edit', compact('langue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //mise à jour methode après soumission de edit
        $request->validate([
        'codeLangue' => 'required|string|max:10',
        'nom' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    // Récupère la langue
    $langue = Langue::findOrFail($id);

    // Met à jour les champs
    $langue->update($request->only('codeLangue', 'nom', 'description'));

    // Redirection avec message
    return redirect()->route('langues.index')
                     ->with('success', 'Langue modifiée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    try {
        $langue = Langue::findOrFail($id);
        $langue->delete();

        return redirect()->route('langues.index')
            ->with('success', 'Langue supprimée avec succès.');
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()->route('langues.index')
            ->with('error', 'Langue non trouvée.');
    } catch (\Throwable $e) {
        \Log::error('Erreur delete langue: ' . $e->getMessage());
        return redirect()->route('langues.index')
            ->with('error', 'Erreur serveur.');
    }
}

}
