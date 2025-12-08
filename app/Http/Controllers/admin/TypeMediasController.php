<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TypeMedia;

class TypeMediasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         $typeMedias = TypeMedia::all();
        return view('admin.typeMedias.index', compact('typeMedias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.typeMedias.create');

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

        TypeMedia::create($request->only('nom'));

        return redirect()->route('typeMedias.index')->with('success', 'TYpe de média ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $typeMedia = TypeMedia::findOrFail($id);

        return response()->json([
            'nom' => $typeMedia->nom,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
         $typeMedia = TypeMedia::findOrFail($id);
        return view('admin.typeMedias.edit', compact('typeMedia'));
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

        $typeMedia = Typemedia::findOrFail($id);
        $typeMedia->update($request->only('nom'));

        return redirect()->route('typeMedias.index')
                         ->with('success', 'Type de médiamodifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $typeMedia = TypeMedia::findOrFail($id);
            $typeMedia->delete();

            return redirect()->route('typeMedias.index')
                             ->with('success', 'Type de média supprimé avec succès.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('typeMedias.index')
                             ->with('error', 'TypeMedia non trouvé.');
        } catch (\Throwable $e) {
            \Log::error('Erreur delete typeMedia: ' . $e->getMessage());
            return redirect()->route('typeMedias.index')
                             ->with('error', 'Erreur serveur.');
        }
    }
}
