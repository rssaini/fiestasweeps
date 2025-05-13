<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'featured',
        'active',
        'min_bet',
        'max_bet',
        'category'
    ];

    protected $casts = [
        'featured' => 'boolean',
        'active' => 'boolean',
        'min_bet' => 'decimal:2',
        'max_bet' => 'decimal:2'
    ];
}