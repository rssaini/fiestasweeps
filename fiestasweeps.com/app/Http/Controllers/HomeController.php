<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredGames = Game::where('featured', true)
                            ->where('active', true)
                            ->take(6)
                            ->get();
        return view('home', compact('featuredGames'));
    }

    public function games()
    {
        return view('games');
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}