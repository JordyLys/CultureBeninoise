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
    $contenu = Contenu::with(['media', 'typeContenu', 'langue', 'region', 'commentaires.user'])->findOrFail($id);

    // Vérifier si l'utilisateur est connecté
    if (Auth::check()) {
        $user = Auth::user();

        // Si admin → accès direct
        if ($user->role === 'admin') {
            return view('front.contenu', compact('contenu'));
        }

        // Utilisateur connecté non admin → vérifier abonnement
        $abonnement = $user->abonnements()
                            ->where(function($q){
                                $q->whereNull('date_fin')
                                  ->orWhere('date_fin', '>=', now());
                            })
                            ->latest()
                            ->first();

        if ($abonnement) {
            // Limite de contenus
            if ($abonnement->contenus_max && $abonnement->contenus_lus >= $abonnement->contenus_max) {
                return redirect()->route('front.abonnement.show', $contenu->id)
                                 ->with('info', 'Votre abonnement est terminé. Veuillez renouveler.');
            }

            // Marquer contenu comme consulté si pas déjà fait
            $deja_consulte = $user->contenu_abonnement()->where('contenu_id', $contenu->id)->exists();
            if (!$deja_consulte) {
                $user->contenu_abonnement()->create(['contenu_id' => $contenu->id]);
                if ($abonnement->contenus_max) {
                    $abonnement->increment('contenus_lus');
                }
            }

            return view('front.contenu', compact('contenu'));
        }

        // Pas d'abonnement actif
        return redirect()->route('front.abonnement.show', $contenu->id)
                         ->with('info', 'Veuillez souscrire un abonnement pour voir ce contenu.');
    }

    // Non connecté → rediriger vers abonnement (paiement)
    return redirect()->route('front.abonnement.show', $contenu->id)
                     ->with('info', 'Veuillez souscrire un abonnement pour voir ce contenu.');
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
