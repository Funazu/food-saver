<?php

namespace App\Http\Controllers\API\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        // Get the authenticated pembeli
        $pembeli = auth()->user()->pembeli;
        $user= auth()->user();

        // Return the pembeli profile data
        return response()->json([
            'nama' => $pembeli->nama,
            'email' => $user->email,
            'alamat' => $pembeli->alamat,
            'no_telepon' => $pembeli->no_telepon,
            'foto_profil' => $pembeli->foto_profil_url,
            'poin_loyalitas' => $pembeli->poin_loyalitas,
        ], 200);
    }
}
