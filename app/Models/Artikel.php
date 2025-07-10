<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'slug',
        'image',
        'date',
        'source',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($artikel) {
            $artikel->slug = Str::slug($artikel->title);
        });

        static::updating(function ($artikel) {
            $artikel->slug = Str::slug($artikel->title);
        });
    }
}
