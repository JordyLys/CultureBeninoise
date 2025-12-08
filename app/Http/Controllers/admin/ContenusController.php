<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contenu;
use App\Models\Region;
use App\Models\Langue;
use App\Models\User;
use App\Models\TypeContenu;
use App\Models\Media;

class ContenusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contenus = Contenu::with(['media', 'typeContenu', 'auteur', 'region', 'langue'])
            ->orderBy('dateCreation', 'desc')
            ->get();

        return view('admin.contenus.index', compact('contenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $regions = Region::all();
        $langues = Langue::all();
        $typesContenu = TypeContenu::all();

        return view('admin.contenus.create', compact('users', 'regions', 'langues', 'typesContenu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'texte' => 'nullable|string',
            'statut' => 'nullable|string',
            'dateCreation' => 'nullable|date',
            'dateValidation' => 'nullable|date',
            'idTypeContenu' => 'required|integer|exists:type_contenu,id',
            'idParent' => 'nullable|integer',
            'idModerateur' => 'nullable|integer',
            'idAuteur' => 'required|integer|exists:users,id',
            'idRegion' => 'required|exists:regions,id',
            'idLangue' => 'required|exists:langues,id',
            'fichier' => 'nullable|file|max:5120',
        ]);

        $contenu = new Contenu($request->all());

        // Gestion du fichier
        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $filename = time().'_'.preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/contenus'), $filename);
            $contenu->fichier = $filename;
        }

        $contenu->save();

        return redirect()->route('front.contenus.index')->with('success', 'Contenu créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Avec toutes les relations nécessaires
        $contenu = Contenu::with([
            'media',
            'typeContenu',
            'auteur',
            'commentaires.user',
            'region',
            'langue'
        ])->findOrFail($id);

        return view('front.contenu', compact('contenu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $contenu = Contenu::findOrFail($id);
        $users = User::all();
        $regions = Region::all();
        $langues = Langue::all();
        $typesContenu = TypeContenu::all();

        return view('admin.contenus.edit', compact('contenu', 'users', 'regions', 'langues', 'typesContenu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $contenu = Contenu::findOrFail($id);

        $request->validate([
            'titre' => 'required|string|max:255',
            'texte' => 'nullable|string',
            'statut' => 'nullable|string',
            'dateCreation' => 'nullable|date',
            'dateValidation' => 'nullable|date',
            'idTypeContenu' => 'required|integer|exists:type_contenu,id',
            'idParent' => 'nullable|integer',
            'idModerateur' => 'nullable|integer',
            'idAuteur' => 'required|integer|exists:users,id',
            'idRegion' => 'required|exists:regions,id',
            'idLangue' => 'required|exists:langues,id',
            'fichier' => 'nullable|file|max:5120',
        ]);

        $contenu->fill($request->all());

        if ($request->hasFile('fichier')) {
            if ($contenu->fichier && file_exists(public_path('uploads/contenus/'.$contenu->fichier))) {
                unlink(public_path('uploads/contenus/'.$contenu->fichier));
            }

            $file = $request->file('fichier');
            $filename = time().'_'.preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/contenus'), $filename);
            $contenu->fichier = $filename;
        }

        $contenu->save();

        return redirect()->route('front.contenus.index')->with('success', 'Contenu modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $contenu = Contenu::findOrFail($id);

        if ($contenu->fichier && file_exists(public_path('uploads/contenus/'.$contenu->fichier))) {
            unlink(public_path('uploads/contenus/'.$contenu->fichier));
        }

        $contenu->delete();

        return redirect()->route('front.contenus.index')->with('success', 'Contenu supprimé avec succès.');
    }
}
