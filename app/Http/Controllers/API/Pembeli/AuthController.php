<?php

namespace App\Http\Controllers\API\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Pembeli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'password'     => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
            'alamat'       => 'required|string|max:255',
            'no_telepon'   => 'required|string|max:255',
            'foto_profil'  => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto_profil')) {
            $fotoPath = $request->file('foto_profil')->store('foto_profil_pembeli', 'public');
        }

        // Buat user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Buat pembeli
        Pembeli::create([
            'user_id'      => $user->id,
            'nama'         => $request->name,
            'alamat'       => $request->alamat,
            'no_telepon'   => $request->no_telepon,
            'poin_loyalitas' => 0,
            'foto_profil'  => $fotoPath,
        ]);

        return response()->json([
            'message' => 'Registrasi berhasil.',
            'user' => $user->only(['id', 'name', 'email']),
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $user = auth()->user();
        $pembeli = Pembeli::where('user_id', $user->id)->first();

        if (!$pembeli) {
            return response()->json(['message' => 'Pembeli not found'], Response::HTTP_NOT_FOUND);
        }

        // Generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user->only(['id', 'name', 'email']),
            'pembeli' => $pembeli,
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Logout successful'], Response::HTTP_OK);
    }
}
