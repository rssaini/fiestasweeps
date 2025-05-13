<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GameSeeder extends Seeder
{
    public function run()
    {
        $games = [
            [
                'name' => 'Buffalo King',
                'slug' => 'buffalo-king',
                'description' => 'Experience the thrill of the wild west with Buffalo King!',
                'image' => 'games/buffalo-king.jpg',
                'featured' => true,
                'active' => true,
                'min_bet' => 1.00,
                'max_bet' => 100.00,
                'category' => 'slots'
            ],
            [
                'name' => 'Sweet Bonanza',
                'slug' => 'sweet-bonanza',
                'description' => 'A delicious candy-themed slot adventure!',
                'image' => 'games/sweet-bonanza.jpg',
                'featured' => true,
                'active' => true,
                'min_bet' => 1.00,
                'max_bet' => 100.00,
                'category' => 'slots'
            ],
            [
                'name' => 'Gates of Olympus',
                'slug' => 'gates-of-olympus',
                'description' => 'Enter the realm of Greek gods and win divine rewards!',
                'image' => 'games/gates-of-olympus.jpg',
                'featured' => true,
                'active' => true,
                'min_bet' => 1.00,
                'max_bet' => 100.00,
                'category' => 'slots'
            ],
            [
                'name' => 'Fruit Party',
                'slug' => 'fruit-party',
                'description' => 'Join the fruity celebration and win big!',
                'image' => 'games/fruit-party.jpg',
                'featured' => true,
                'active' => true,
                'min_bet' => 1.00,
                'max_bet' => 100.00,
                'category' => 'slots'
            ],
            [
                'name' => 'Big Bass Splash',
                'slug' => 'big-bass-splash',
                'description' => 'Reel in the biggest catches and biggest wins!',
                'image' => 'games/big-bass-splash.jpg',
                'featured' => true,
                'active' => true,
                'min_bet' => 1.00,
                'max_bet' => 100.00,
                'category' => 'slots'
            ],
            [
                'name' => 'Sugar Rush',
                'slug' => 'sugar-rush',
                'description' => 'A sweet adventure with delicious prizes!',
                'image' => 'games/sugar-rush.jpg',
                'featured' => true,
                'active' => true,
                'min_bet' => 1.00,
                'max_bet' => 100.00,
                'category' => 'slots'
            ]
        ];

        foreach ($games as $game) {
            Game::create($game);
        }
    }
}