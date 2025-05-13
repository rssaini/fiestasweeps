<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
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

    public function play($slug)
    {
        $game = Game::where('slug', $slug)
                    ->where('active', true)
                    ->firstOrFail();

        return view('games.play', compact('game'));
    }
}