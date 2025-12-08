<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThemeController extends Controller
{
    public function toggle(Request $request)
    {
        $user = Auth::user();

        // Basculer le thème
        $user->theme = $user->theme === 'dark' ? 'light' : 'dark';
        $user->save();

        // Retourner vrai/faux pour JS
        return response()->json(['theme' => $user->theme]);
    }
}
