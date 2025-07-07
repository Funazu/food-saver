<?php

namespace App\Http\Controllers\API\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Makanan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $pembeli = auth()->user()->pembeli;

        $pesanan = Pesanan::with(['makanan', 'penjual'])
            ->where('pembeli_id', $pembeli->id)
            ->latest()
            ->get();

        // Tambahkan field ulasan untuk setiap pesanan
        $pesanan = $pesanan->map(function ($item) use ($pembeli) {
            $ulasan = $item->ulasan()
                ->where('pembeli_id', $pembeli->id)
                ->where('pesanan_id', $item->id)
                ->first();
            $item->ulasan = $ulasan;
            return $item;
        });

        return response()->json($pesanan, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'makanan_id'         => 'required|exists:makanans,id',
            'quantity'        => 'required|integer|min:1',
            'pickup_date'     => 'required|date|after_or_equal:today',
            'payment_method' => 'required|string|in:cash,transfer,qris',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $currentTime = now()->format('H:i:s');
        $pembeli = auth()->user()->pembeli;

        $makanan = Makanan::findOrFail($request->makanan_id);

        if ($makanan->status === 'unavailable' || $makanan->current_stock < $request->quantity) {
            return response()->json(['error' => 'Makanan tidak tersedia'], 404);
        }

        $now = now();

        // Cek jam buka dan tutup penjual
        $jamBuka = $now->copy()->setTimeFromTimeString($makanan->penjual->jam_buka);
        $jamTutup = $now->copy()->setTimeFromTimeString($makanan->penjual->jam_tutup);

        // Cek waktu mulai dan akhir pemesanan makanan
        $startTime = $now->copy()->setTimeFromTimeString($makanan->start_time);
        $endTime = $now->copy()->setTimeFromTimeString($makanan->end_time);

        if (!$now->between($jamBuka, $jamTutup)) {
            return response()->json(['error' => 'Penjual tidak buka pada waktu ini'], 400);
        }

        if (!$now->between($startTime, $endTime)) {
            return response()->json(['error' => 'Makanan tidak dapat dipesan pada waktu ini'], 400);
        }

        $pesanan = Pesanan::create([
            'pembeli_id' => $pembeli->id,
            'penjual_id' => $makanan->penjual_id,
            'makanan_id' => $makanan->id,
            'quantity' => $request->quantity,
            'total_price' => $makanan->original_price * $request->quantity,
            'status' => 'pending',
            'order_date' => now()->toDateTimeString(),
            'pickup_date' => $request->pickup_date,
            'payment_method' => $request->payment_method,
            'unique_code' => strtoupper(uniqid('PSN')),
        ]);

        return response()->json([
            'message' => 'Pesanan berhasil dibuat',
            'pesanan' => $pesanan,
        ], 201);
    }

    public function batalkanPesanan($id)
    {
        $pesanan = Pesanan::find($id);
        if (!$pesanan) {
            return response()->json(['error' => 'Pesanan tidak ditemukan'], 404);
        }

        if ($pesanan->status !== 'pending') {
            return response()->json(['error' => 'Hanya pesanan dengan status pending yang dapat dibatalkan'], 400);
        }

        $pesanan->status = 'dibatalkan_pembeli';
        $pesanan->save();

        return response()->json(['message' => 'Pesanan berhasil dibatalkan'], 200);
    }

    public function buatUlasan(Request $request, $pesananId)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pesanan = Pesanan::find($pesananId);
        if (!$pesanan) {
            return response()->json(['error' => 'Pesanan tidak ditemukan'], 404);
        }

        if ($pesanan->status !== 'sudah_diambil') {
            return response()->json(['error' => 'Hanya pesanan yang sudah diambil yang dapat diulas'], 400);
        }

        $ulasan = $pesanan->ulasan()->create([
            'pembeli_id' => auth()->user()->pembeli->id,
            'penjual_id' => $pesanan->penjual_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'tanggal_ulasan' => now(),
        ]);

        return response()->json(['message' => 'Ulasan berhasil dibuat', 'ulasan' => $ulasan], 201);
    }
}
