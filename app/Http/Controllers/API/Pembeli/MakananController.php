<?php

namespace App\Http\Controllers\API\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Makanan;
use Illuminate\Http\Request;

class MakananController extends Controller
{
    public function index(Request $request)
    {
        $query = Makanan::with(['kategori', 'penjual'])
            ->where('status', '!=', 'inactive')
            ->latest();

        if ($request->has('name') && $request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('kategori_id') && $request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->has('penjual_id') && $request->penjual_id) {
            $query->where('penjual_id', $request->penjual_id);
        }

        $makanan = $query->get()->map(function ($item) {
            $item->image = env('APP_URL') . '/storage/' . ltrim($item->image, '/');
            return $item;
        });

        return response()->json($makanan, 200);
    }

    public function detail($id)
    {
        $makanan = Makanan::with(['kategori', 'penjual'])->findOrFail($id);
        $makanan->image = env('APP_URL') . '/storage/' . ltrim($makanan->image, '/');

        return response()->json($makanan, 200);
    }

    public function kategori()
    {
        $kategori = Kategori::latest()->get();

        return response()->json($kategori, 200);
    }
}
