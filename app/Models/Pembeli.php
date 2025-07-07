<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembeli extends Model
{
    use HasFactory;
    
    protected $appends = ['foto_profil_url'];
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFotoProfilUrlAttribute()
    {
        return $this->foto_profil ? asset('storage/' . $this->foto_profil) : asset('images/default-profile.png');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class);
    }
}
