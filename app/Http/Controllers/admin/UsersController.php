<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Langue;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roles = Role::all();     // récupère tous les rôles
        $langues = Langue::all(); // récupère toutes les langues

        return view('admin.users.create', compact('roles', 'langues'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des champs
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'sexe' => 'required|in:M,F,O',
            'dateNaissance' => 'nullable|date',
            'idRole' => 'required|exists:roles,id',
            'idLangue' => 'required|exists:langues,id',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', // 5MB
        ]);

        // Création d'un nouvel utilisateur
        $user = new User;
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->sexe = $request->sexe;
        $user->dateNaissance = $request->dateNaissance;
        $user->idRole = $request->idRole;
        $user->idLangue = $request->idLangue;

         if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('users', 'public'); // stocke dans storage/app/public/users
        $user->photo = $path;
    }

        $user->save();

        return redirect()->route('users.create')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with(['role', 'langue'])->findOrFail($id);

        return response()->json([
            'nom' => $user->nom,
            'prenom' => $user->prenom,
            'email' => $user->email,
            'sexe' => $user->sexe,
            'statut' => $user->statut,
            'photo' => $user->photo, // nom du fichier ou chemin relatif
            'dateNaissance' => $user->dateNaissance,
            'dateInscription' => $user->dateInscription,
            'role' => $user->role ? $user->role->nom : null,
            'langue' => $user->langue ? $user->langue->nom : null,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Récupérer l'utilisateur
        $user = User::findOrFail($id);

        // Validation
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6', // mot de passe facultatif
            'sexe' => 'required|in:M,F,O',
            'dateNaissance' => 'nullable|date',
            'idRole' => 'required|exists:roles,id',
            'idLangue' => 'required|exists:langues,id',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', // 5MB
        ]);

        // Mise à jour des champs
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->sexe = $request->sexe;
        $user->dateNaissance = $request->dateNaissance;
        $user->idRole = $request->idRole;
        $user->idLangue = $request->idLangue;

        // Mot de passe : uniquement si renseigné
        if (! empty($request->password)) {
            $user->password = bcrypt($request->password);
        }

        // Upload photo/document
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->photo && file_exists(public_path('uploads/users/'.$user->photo))) {
                unlink(public_path('uploads/users/'.$user->photo));
            }

            $file = $request->file('photo');
            $filename = time().'_'.preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/users'), $filename);
            $user->photo = $filename;
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Utilisateur modifié avec succès.');
    }
  // User.php
public function role() {
    return $this->belongsTo(Role::class, 'idRole'); // <-- ici
}



    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
{
    try {
        // Récupère l'utilisateur ou échoue
        $user = User::findOrFail($id);

        // Supprime la photo si elle existe
        if ($user->photo && file_exists(public_path('uploads/users/' . $user->photo))) {
            unlink(public_path('uploads/users/' . $user->photo));
        }

        // Supprime l'utilisateur
        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'Utilisateur supprimé avec succès.');
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()->route('users.index')
                         ->with('error', 'Utilisateur non trouvé.');
    } catch (\Throwable $e) {
        \Log::error('Erreur suppression utilisateur: ' . $e->getMessage());
        return redirect()->route('users.index')
                         ->with('error', 'Erreur serveur lors de la suppression.');
    }
}

}
