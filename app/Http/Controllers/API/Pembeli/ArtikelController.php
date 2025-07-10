<?php

namespace App\Http\Controllers\API\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::latest()->get()->map(function ($artikel) {
            $artikel->image = $artikel->image ? url('storage/' . $artikel->image) : null;
            return $artikel;
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar Artikel',
            'data' => $artikels
        ], 200);
    }

    public function show($slug)
    {
        $artikel = Artikel::where('slug', $slug)->first();
        if ($artikel && $artikel->image) {
            $artikel->image = url('storage/' . $artikel->image);
        }

        if (!$artikel) {
            return response()->json([
                'success' => false,
                'message' => 'Artikel tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Artikel',
            'data' => $artikel
        ], 200);
    }
}
