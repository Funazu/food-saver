<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanans';
    protected $guarded = ['id'];

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class);
    }

    public function penjual()
    {
        return $this->belongsTo(Penjual::class);
    }

    public function makanan()
    {
        return $this->belongsTo(Makanan::class);
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class);
    }
}
