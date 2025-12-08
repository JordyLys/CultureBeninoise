<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contenu;
use App\Models\Region;
use App\Models\Langue;
use App\Models\User;
use App\Models\TypeContenu;
use App\Models\Media;

class ContenusFrontController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contenus = Contenu::with(['media', 'typeContenu', 'auteur', 'region', 'langue'])
            ->orderBy('dateCreation', 'desc')
            ->get();

        return view('front.contenus.index', compact('contenus'));
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

        return view('front.contenus.create', compact('users', 'regions', 'langues', 'typesContenu'));
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
    $user = auth()->user();
    $contenu = Contenu::findOrFail($id);

    $abonnement = $user->abonnements()
                        ->where(function($q){
                            $q->whereNull('date_fin')
                              ->orWhere('date_fin', '>=', now());
                        })
                        ->latest()
                        ->first();

    if($abonnement) {
        // si abonnement limité en nombre de contenus
        if($abonnement->contenus_max && $abonnement->contenus_lus >= $abonnement->contenus_max) {
            return redirect()->route('front.abonnement.show', $contenu->id)
                             ->with('info', 'Votre abonnement est terminé. Veuillez renouveler.');
        }

        // si contenu déjà consulté, ne pas compter
        $deja_consulte = $user->contenu_abonnement()->where('contenu_id', $contenu->id)->exists();
        if(!$deja_consulte) {
            // marquer comme consulté
            $user->contenu_abonnement()->create(['contenu_id' => $contenu->id]);
            if($abonnement->contenus_max) {
                $abonnement->increment('contenus_lus');
            }
        }

        return view('front.contenu', compact('contenu'));
    }

    // aucun abonnement actif
    return redirect()->route('front.abonnement.show', $contenu->id)
                     ->with('info', 'Veuillez souscrire un abonnement pour voir ce contenu.');
}

    public function section($slug)
{
    $contenus = Contenu::whereHas('typeContenu', function ($q) use ($slug) {
        $q->where('nom', $slug); // remplacer slug par nom
    })
    ->with(['media', 'langue', 'region', 'typeContenu'])
    ->paginate(12);

    return view('front.sections', compact('contenus', 'slug'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function typeContenu()
{
    return $this->belongsTo(TypeContenu::class, 'idTypeContenu');
}

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
        if ($request->filled('password')) {
    $user->password = Hash::make($request->password);
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
