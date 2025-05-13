<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DownloadGameAssets extends Command
{
    protected $signature = 'assets:download';
    protected $description = 'Download game assets from source website';

    public function handle()
    {
        $gameImages = [
            'buffalo-king.jpg',
            'sweet-bonanza.jpg',
            'gates-of-olympus.jpg',
            'fruit-party.jpg',
            'big-bass-splash.jpg',
            'sugar-rush.jpg'
        ];

        $baseUrl = 'https://playfunspot.com/images/games/';
        $savePath = public_path('images/games/');

        foreach ($gameImages as $image) {
            $response = Http::get($baseUrl . $image);
            if ($response->successful()) {
                file_put_contents($savePath . $image, $response->body());
                $this->info("Downloaded: $image");
            }
        }

        // Download logos
        $logos = ['logo.png', 'logo-dark.png', 'favicon.ico'];
        $logoBaseUrl = 'https://playfunspot.com/images/';
        $logoSavePath = public_path('images/logos/');

        foreach ($logos as $logo) {
            $response = Http::get($logoBaseUrl . $logo);
            if ($response->successful()) {
                file_put_contents($logoSavePath . $logo, $response->body());
                $this->info("Downloaded: $logo");
            }
        }
    }
}