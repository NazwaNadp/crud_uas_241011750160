<?php

namespace App\Http\Controllers;

use App\Models\Dessert;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Dessert::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nama_dessert', 'like', "%{$search}%");
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        $desserts = $query->latest('id_dessert')->paginate(8)->withQueryString();
        $kategoriList = Dessert::query()->select('kategori')->distinct()->pluck('kategori');

        return view('home', compact('desserts', 'kategoriList'));
    }
}
