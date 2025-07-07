<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function penjual()
    {
        return $this->belongsTo(Penjual::class);
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }
}
