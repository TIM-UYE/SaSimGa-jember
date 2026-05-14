<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\KategoriMenu;
use App\Models\Menu;
use App\Models\Testimoni;
use App\Models\Video;

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

        $galeris = Galeri::where('is_active', true)
            ->orderByDesc('created_at')
            ->get();

        $videos = Video::where('is_active', true)
            ->orderByDesc('created_at')
            ->get();

        return view('frontend.pages.home', compact('menus', 'kategoris', 'testimonis', 'galeris', 'videos'));
    }
}
