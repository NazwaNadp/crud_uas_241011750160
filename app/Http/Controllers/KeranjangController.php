<?php

namespace App\Http\Controllers;

use App\Models\Dessert;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    /**
     * Ambil isi keranjang dari session.
     */
    private function getKeranjang(): array
    {
        return session('keranjang', []);
    }

    /**
     * Simpan keranjang ke session.
     */
    private function saveKeranjang(array $keranjang): void
    {
        session(['keranjang' => $keranjang]);
    }

    /**
     * Halaman lihat keranjang.
     */
    public function index()
    {
        $keranjang = $this->getKeranjang();
        $total = collect($keranjang)->sum(fn($item) => $item['harga'] * $item['jumlah']);

        return view('keranjang.index', compact('keranjang', 'total'));
    }

    /**
     * Tambah item ke keranjang.
     */
    public function tambah(Request $request)
    {
        $request->validate([
            'dessert_id' => ['required', 'integer', 'exists:desserts,id_dessert'],
            'jumlah'     => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $dessert = Dessert::findOrFail($request->dessert_id);
        $keranjang = $this->getKeranjang();
        $key = 'dessert_' . $dessert->id_dessert;

        if (isset($keranjang[$key])) {
            $keranjang[$key]['jumlah'] += (int) $request->jumlah;
        } else {
            $keranjang[$key] = [
                'dessert_id'   => $dessert->id_dessert,
                'nama_dessert' => $dessert->nama_dessert,
                'harga'        => (float) $dessert->harga,
                'gambar'       => $dessert->gambar,
                'jumlah'       => (int) $request->jumlah,
            ];
        }

        $this->saveKeranjang($keranjang);

        return response()->json([
            'success' => true,
            'message' => $dessert->nama_dessert . ' ditambahkan ke keranjang!',
            'count'   => count($keranjang),
        ]);
    }

    /**
     * Update jumlah item di keranjang.
     */
    public function update(Request $request, string $key)
    {
        $request->validate([
            'jumlah' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $keranjang = $this->getKeranjang();

        if (isset($keranjang[$key])) {
            $keranjang[$key]['jumlah'] = (int) $request->jumlah;
            $this->saveKeranjang($keranjang);
        }

        return redirect()->route('keranjang.index')->with('success', 'Jumlah diperbarui.');
    }

    /**
     * Hapus satu item dari keranjang.
     */
    public function hapus(string $key)
    {
        $keranjang = $this->getKeranjang();
        unset($keranjang[$key]);
        $this->saveKeranjang($keranjang);

        return redirect()->route('keranjang.index')->with('success', 'Item dihapus dari keranjang.');
    }

    /**
     * Kosongkan seluruh keranjang.
     */
    public function kosongkan()
    {
        session()->forget('keranjang');

        return redirect()->route('keranjang.index')->with('success', 'Keranjang dikosongkan.');
    }

    /**
     * Tampilkan form checkout.
     */
    public function checkout()
    {
        $keranjang = $this->getKeranjang();

        if (empty($keranjang)) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang kamu masih kosong.');
        }

        $total = collect($keranjang)->sum(fn($item) => $item['harga'] * $item['jumlah']);

        return view('keranjang.checkout', compact('keranjang', 'total'));
    }

    /**
     * Proses checkout: simpan semua item sebagai pesanan ke database.
     */
    public function prosesCheckout(Request $request)
    {
        $request->validate([
            'nama_pemesan' => ['required', 'string', 'max:100'],
            'no_hp'        => ['required', 'string', 'max:20'],
            'catatan'      => ['nullable', 'string', 'max:500'],
        ], [
            'nama_pemesan.required' => 'Nama pemesan wajib diisi.',
            'no_hp.required'        => 'Nomor HP wajib diisi.',
        ]);

        $keranjang = $this->getKeranjang();

        if (empty($keranjang)) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang kamu masih kosong.');
        }

        foreach ($keranjang as $item) {
            Pesanan::create([
                'dessert_id'   => $item['dessert_id'],
                'nama_pemesan' => $request->nama_pemesan,
                'no_hp'        => $request->no_hp,
                'jumlah'       => $item['jumlah'],
                'catatan'      => $request->catatan,
                'total_harga'  => $item['harga'] * $item['jumlah'],
                'status'       => 'pending',
            ]);
        }

        session()->forget('keranjang');

        return redirect()->route('home')->with('success', 'Pesanan kamu berhasil dikirim! Kami akan segera menghubungi kamu.');
    }
}
