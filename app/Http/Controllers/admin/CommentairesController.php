<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commentaire;
use App\Models\User;
use App\Models\Contenu;

class CommentairesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commentaires = Commentaire::with(['user', 'contenu'])->get();
        return view('admin.commentaires.index', compact('commentaires'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $contenus = Contenu::all();

        return view('admin.commentaires.create', compact('users', 'contenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'texte' => 'required|string',
            'note' => 'required|integer|min:0|max:5',
            'idUsers' => 'required|exists:users,id',
            'idContenu' => 'required|exists:contenus,id',
        ]);

        Commentaire::create([
            'texte' => $request->texte,
            'note' => $request->note,
            'idUsers' => $request->idUsers,
            'idContenu' => $request->idContenu,
        ]);

        return redirect()->route('commentaires.index')->with('success', 'Commentaire créé avec succès.');
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
    public function edit(string $id)
    {
        $commentaire = Commentaire::findOrFail($id);
        $users = User::all();
        $contenus = Contenu::all();

        return view('admin.commentaires.edit', compact('commentaire', 'users', 'contenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $commentaire = Commentaire::findOrFail($id);

        $request->validate([
            'texte' => 'required|string',
            'note' => 'required|integer|min:0|max:5',
            'idUsers' => 'required|exists:users,id',
            'idContenu' => 'required|exists:contenus,id',
        ]);

        $commentaire->update([
            'texte' => $request->texte,
            'note' => $request->note,
            'idUsers' => $request->idUsers,
            'idContenu' => $request->idContenu,
        ]);

        return redirect()->route('commentaires.index')->with('success', 'Commentaire modifié avec succès.');
    }

    /**
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
