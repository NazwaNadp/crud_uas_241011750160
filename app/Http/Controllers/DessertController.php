<?php

namespace App\Http\Controllers;

use App\Models\Dessert;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DessertController extends Controller
{
    /**
     * 
     *
     * @var list<string>
     */
    protected array $kategoriList = [
        'Cake',
        'Ice Cream',
        'Pudding',
        'Pastry',
        'Traditional',
        'Beverage Dessert',
    ];

    /**
     * 
     */
    public function index(Request $request)
    {
        $query = Dessert::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_dessert', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('komposisi', 'like', "%{$search}%");
            });
        }

        $desserts = $query->latest('id_dessert')->paginate(10)->withQueryString();

        return view('desserts.index', compact('desserts'));
    }

    /**
     * 
     */
    public function create()
    {
        $kategoriList = $this->kategoriList;

        return view('desserts.create', compact('kategoriList'));
    }

    /**
     * 
     */
    public function store(Request $request)
    {
        $validated = $this->validateDessert($request);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('desserts', 'public');
        }

        Dessert::create($validated);

        return redirect()
            ->route('desserts.index')
            ->with('success', 'Data dessert berhasil ditambahkan.');
    }

    /**
     */
    public function show(Dessert $dessert)
    {
        return view('desserts.show', compact('dessert'));
    }

    /**
     */
    public function edit(Dessert $dessert)
    {
        $kategoriList = $this->kategoriList;

        return view('desserts.edit', compact('dessert', 'kategoriList'));
    }

    /**
     */
    public function update(Request $request, Dessert $dessert)
    {
        $validated = $this->validateDessert($request, $dessert->id_dessert);

        if ($request->hasFile('gambar')) {
            if ($dessert->gambar) {
                Storage::disk('public')->delete($dessert->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('desserts', 'public');
        }

        $dessert->update($validated);

        return redirect()
            ->route('desserts.index')
            ->with('success', 'Data dessert berhasil diperbarui.');
    }

    /**
     */
    public function destroy(Dessert $dessert)
    {
        if ($dessert->gambar) {
            Storage::disk('public')->delete($dessert->gambar);
        }

        $dessert->delete();

        return redirect()
            ->route('desserts.index')
            ->with('success', 'Data dessert berhasil dihapus.');
    }

    /**
     */
    public function exportPdf()
    {
        $desserts = Dessert::orderBy('kategori')->orderBy('nama_dessert')->get();

        $pdf = Pdf::loadView('desserts.pdf', compact('desserts'))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-data-menu-dessert-' . now()->format('Ymd_His') . '.pdf');
    }

    /**
     */
    private function validateDessert(Request $request, ?int $ignoreId = null): array
    {
        $rules = [
            'nama_dessert' => ['required', 'string', 'max:150'],
            'komposisi' => ['required', 'string', 'max:1000'],
            'harga' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'kategori' => ['required', 'string', 'in:' . implode(',', $this->kategoriList)],
            'gambar' => [
                $ignoreId ? 'nullable' : 'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ];

        return $request->validate($rules, [
            'nama_dessert.required' => 'Nama dessert wajib diisi.',
            'komposisi.required' => 'Komposisi wajib diisi.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'kategori.required' => 'Kategori wajib dipilih.',
            'kategori.in' => 'Kategori tidak valid.',
            'gambar.required' => 'Gambar wajib diunggah.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);
    }
}
