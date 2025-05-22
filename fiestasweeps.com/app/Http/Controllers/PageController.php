<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $games = [
            [
                'name' => 'Orion Stars',
                'image' => 'orionstars.png',
                'description' => 'An innovative sweepstakes and skill-based gaming platform that blends classic arcade-style games with modern technology. It offers a diverse range of games, including fish games, slot games, and skill-based challenges, making it appealing to both casual and competitive players.'
            ],
            [
                'name' => 'Juwa',
                'image' => 'juwa.png',
                'description' => 'A skill-based gaming platform that specializes in fish table games, offering an engaging arcade-style experience. Players aim and shoot at virtual sea creatures, testing their precision and strategy. The game features 14 unique variations, each with different visuals, gameplay speeds, and objectives.'
            ],
            [
                'name' => 'River Sweeps',
                'image' => 'riversweeps.png',
                'description' => 'A sweepstakes gaming platform that offers a variety of fish games, slot games, keno, and poker. It provides an engaging experience where players can compete in fish redemption shooter games, testing their skills to win prizes.'
            ],
            [
                'name' => 'Fire Kirin',
                'image' => 'firekirin.png',
                'description' => 'An exciting gaming platform featuring various skill-based games and sweepstakes opportunities.'
            ]
        ];

        return view('pages.index', compact('games'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function refunds()
    {
        return view('pages.refunds');
    }

    public function register()
    {
        return view('pages.register');
    }

    public function responsible()
    {
        return view('pages.responsible');
    }

    public function signin()
    {
        return view('pages.signin');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        // Add your email sending logic here
        
        return redirect()->back()->with('success', 'Thank you for your message. We will contact you soon!');
    }
}
