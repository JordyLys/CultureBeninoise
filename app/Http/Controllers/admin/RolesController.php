<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.roles.create');

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

        Role::create($request->only('nom'));

        return redirect()->route('roles.index')->with('success', 'Role ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $role = Role::findOrFail($id);

        return response()->json([
            'nom' => $role->nom,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
         $role = Role::findOrFail($id);
        return view('admin.roles.edit', compact('role'));
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

        $role = Role::findOrFail($id);
        $role->update($request->only('nom'));

        return redirect()->route('roles.index')
                         ->with('success', 'Role modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return redirect()->route('roles.index')
                             ->with('success', 'Role supprimé avec succès.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('roles.index')
                             ->with('error', 'Role non trouvé.');
        } catch (\Throwable $e) {
            \Log::error('Erreur delete role: ' . $e->getMessage());
            return redirect()->route('roles.index')
                             ->with('error', 'Erreur serveur.');
        }
    }
}
