<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commentaire;
use App\Models\User;
use App\Models\Contenu;

class CommentairesFrontController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commentaires = Commentaire::with(['user', 'contenu'])->get();
        return view('front.commentaires.index', compact('commentaires'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $contenus = Contenu::all();

        return view('front.commentaires.create', compact('users', 'contenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request, $id)
{
    $request->validate([
        'texte' => 'required|string|max:1000',
    ]);

    $contenu = Contenu::findOrFail($id);


 Commentaire::create([
            'texte' => $request->texte,
            'idUsers' => auth()->id(),
            'idContenu' => $contenu->id,
        ]);

    return redirect()->back()->with('success', 'Commentaire ajouté avec succès !');
}


    /**
     * Display the specified resource (JSON pour modal).
     */
    public function show(string $id)
    {
        $commentaire = Commentaire::with(['user', 'contenu'])->findOrFail($id);

        return response()->json([
            'texte' => $commentaire->texte,
            'note' => $commentaire->note,
            'user' => $commentaire->user ? $commentaire->user->nom . ' ' . $commentaire->user->prenom : null,
            'contenu' => $commentaire->contenu ? $commentaire->contenu->titre : null,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.



     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $commentaire = Commentaire::findOrFail($id);
            $commentaire->delete();

            return redirect()->route('commentaires.index')
                             ->with('success', 'Commentaire supprimé avec succès.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('commentaires.index')
                             ->with('error', 'Commentaire non trouvé.');
        } catch (\Throwable $e) {
            \Log::error('Erreur suppression commentaire: ' . $e->getMessage());
            return redirect()->route('commentaires.index')
                             ->with('error', 'Erreur serveur lors de la suppression.');
        }
    }
}
