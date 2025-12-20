<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contenu;
use App\Models\Region;
use App\Models\Langue;
use App\Models\User;
use App\Models\TypeContenu;

class ContenusFrontController extends Controller
{
    /**
     * Affiche la liste des contenus
     */
    public function index()
    {
        $contenus = Contenu::with(['media', 'typeContenu', 'auteur', 'region', 'langue'])
            ->orderBy('dateCreation', 'desc')
            ->get();

        return view('front.contenus.index', compact('contenus'));
    }

    /**
     * Formulaire de création d'un contenu (admin)
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
     * Stocke un nouveau contenu
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
     * Affiche un contenu spécifique
     */
   public function show($id)
{
    // Récupérer le contenu
    $contenu = Contenu::with(['media', 'typeContenu'])->findOrFail($id);

    // (Optionnel) log admin
    if (auth()->check() && auth()->user()->role === 'admin') {
        \Log::info('Admin access granted', ['contenu_id' => $id]);
    }

    // ACCÈS LIBRE AU CONTENU
    return view('front.contenu', compact('contenu'));
}

    /**
     * Affiche les contenus d'une section
     */
    public function section($slug)
    {
        $contenus = Contenu::whereHas('typeContenu', function ($q) use ($slug) {
            $q->where('nom', $slug);
        })
        ->with(['media', 'langue', 'region', 'typeContenu'])
        ->paginate(12);

        return view('front.sections', compact('contenus', 'slug'));
    }

    /**
     * Formulaire d'édition
     */
    public function edit($id)
    {
        $contenu = Contenu::findOrFail($id);
        $users = User::all();
        $regions = Region::all();
        $langues = Langue::all();
        $typesContenu = TypeContenu::all();

        return view('front.contenus.edit', compact('contenu', 'users', 'regions', 'langues', 'typesContenu'));
    }

    /**
     * Met à jour un contenu
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
     * Supprime un contenu
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

