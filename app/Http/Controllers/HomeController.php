<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\KategoriMenu;
use App\Models\Testimoni;

class HomeController extends Controller
{
    public function index()
    {
        $menus = Menu::where('is_available', true)
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->get();

        $kategoris = KategoriMenu::where('is_active', true)
            ->withCount(['menus' => function($query) {
                $query->where('is_available', true);
            }])
            ->get();

        $testimonis = Testimoni::where('is_active', true)
            ->orderByDesc('review_date')
            ->limit(3)
            ->get();

        return view('frontend.pages.home', compact('menus', 'kategoris', 'testimonis'));
    }
}
