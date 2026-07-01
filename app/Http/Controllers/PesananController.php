<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    /**
     * Daftar semua pesanan masuk.
     */
    public function index(Request $request)
    {
        $query = Pesanan::with('dessert')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pesanan = $query->paginate(15)->withQueryString();
        $totalPending = Pesanan::where('status', 'pending')->count();

        return view('pesanan.index', compact('pesanan', 'totalPending'));
    }

    /**
     * Update status pesanan.
     */
    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'status' => ['required', 'in:pending,diproses,selesai,dibatalkan'],
        ]);

        $pesanan->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Hapus pesanan.
     */
    public function destroy(Pesanan $pesanan)
    {
        $pesanan->delete();

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
