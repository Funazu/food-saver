<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Penjual
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user) {
            Log::warning('🔒 Tidak ada user login');
            abort(403, 'Unauthorized.');
        }

        $penjual = $user->penjual;


        if ($penjual->status_verifikasi !== 'verified') {
            return redirect()->route('inactive.penjual')->with('error', 'Belum diverifikasi');
        }

        Log::info('✅ Akses granted ke panel penjual');

        return $next($request);
    }
}
