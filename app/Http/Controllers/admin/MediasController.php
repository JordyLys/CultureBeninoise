<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\Contenu;
use App\Models\TypeMedia;

class MediasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medias = Media::with(['contenu', 'typeMedia'])->get();
        return view('admin.medias.index', compact('medias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contenus = Contenu::all();
        $typesMedia = TypeMedia::all();

        return view('admin.medias.create', compact('contenus', 'typesMedia'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'chemin' => 'required|file|max:10240', // 10 Mo max
            'idTypeMedia' => 'required|integer|exists:type_medias,id',
            'idContenu' => 'required|integer|exists:contenus,id',
        ]);

        $media = new Media();
        $media->description = $request->description;
        $media->idTypeMedia = $request->idTypeMedia;
        $media->idContenu = $request->idContenu;

        if ($request->hasFile('chemin')) {
            $file = $request->file('chemin');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/medias'), $filename);
            $media->chemin = $filename;
        }

        $media->save();

        return redirect()->route('medias.index')->with('success', 'Média créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $media = Media::with(['contenu', 'typeMedia'])->findOrFail($id);

        return response()->json([
            'description' => $media->description,
            'chemin' => $media->chemin,
            'typeMedia' => $media->typeMedia ? $media->typeMedia->nom : null,
            'contenu' => $media->contenu ? $media->contenu->titre : null,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $media = Media::findOrFail($id);
        $contenus = Contenu::all();
        $typesMedia = TypeMedia::all();

        return view('admin.medias.edit', compact('media', 'contenus', 'typesMedia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $media = Media::findOrFail($id);

        $request->validate([
            'description' => 'required|string|max:255',
            'chemin' => 'nullable|file|max:10240', // 10 Mo max
            'idTypeMedia' => 'required|integer|exists:type_medias,id',
            'idContenu' => 'required|integer|exists:contenus,id',
        ]);

        $media->description = $request->description;
        $media->idTypeMedia = $request->idTypeMedia;
        $media->idContenu = $request->idContenu;

        if ($request->hasFile('chemin')) {
            if ($media->chemin && file_exists(public_path('uploads/medias/'.$media->chemin))) {
                unlink(public_path('uploads/medias/'.$media->chemin));
            }
            $file = $request->file('chemin');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/medias'), $filename);
            $media->chemin = $filename;
        }

        $media->save();

        return redirect()->route('medias.index')->with('success', 'Média modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $media = Media::findOrFail($id);
            if ($media->chemin && file_exists(public_path('uploads/medias/'.$media->chemin))) {
                unlink(public_path('uploads/medias/'.$media->chemin));
            }
            $media->delete();

            return redirect()->route('medias.index')
                             ->with('success', 'Média supprimé avec succès.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('medias.index')
                             ->with('error', 'Média non trouvé.');
        } catch (\Throwable $e) {
            \Log::error('Erreur suppression média: ' . $e->getMessage());
            return redirect()->route('medias.index')
                             ->with('error', 'Erreur serveur lors de la suppression.');
        }
    }
}
