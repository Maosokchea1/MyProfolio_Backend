<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'percentage',
        'category',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'percentage' => 'integer',
            'sort_order' => 'integer',
        ];
    }
}