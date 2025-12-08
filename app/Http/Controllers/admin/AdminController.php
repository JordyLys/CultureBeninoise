<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contenu;
use App\Models\Media;


class AdminController extends Controller
{
    public function index()
    {
        // Statistiques
        $usersCount = User::count();
        $contentsCount = Contenu::count();
        $mediaCount = Media::count();


        // Contenus récents
        $latestContents = Contenu::latest()->take(5)->get();

        return view('admin.dashboard', compact('usersCount', 'contentsCount', 'mediaCount', 'latestContents'));
    }
}
