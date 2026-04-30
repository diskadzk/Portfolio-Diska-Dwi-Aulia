<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'Novel',
        'Teknologi',
        'Sains',
        'Bisnis',
        'Referensi',
    ];

    protected $fillable = [
        'title',
        'author',
        'category',
        'published_year',
        'stock',
        'summary',
    ];

    protected function casts(): array
    {
        return [
            'published_year' => 'integer',
            'stock' => 'integer',
        ];
    }

    public static function categories(): array
    {
        return self::CATEGORIES;
    }
}