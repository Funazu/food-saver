<?php

namespace App\Http\Controllers\API\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Penjual;
use Illuminate\Http\Request;

class PenjualController extends Controller
{
    public function index(Request $request)
    {
        $query = Penjual::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Penjual',
            'data' => $query
        ], 200);
    }
}
