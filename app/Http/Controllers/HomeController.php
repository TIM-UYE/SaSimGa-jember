<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\KategoriMenu;

class HomeController extends Controller
{
    public function index()
    {
        $menus = Menu::where('is_available', true)
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        $kategoris = KategoriMenu::where('is_active', true)
            ->withCount(['menus' => function($query) {
                $query->where('is_available', true);
            }])
            ->get();

        return view('frontend.pages.home', compact('menus', 'kategoris'));
    }
}
