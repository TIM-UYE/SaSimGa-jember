<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\KategoriMenu;
use App\Models\MenuSpecial;
use App\Models\Stok;
use App\Models\MenuBahan;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('kategori')->orderBy('created_at', 'desc')->get();

        return view('admin.menu.index', compact('menus'));
    }

    public function frontend()
    {
        $menus = Menu::with('kategori')
            ->where('is_available', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $specials = MenuSpecial::with('items')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $kategoris = KategoriMenu::where('is_active', true)
            ->withCount(['menus' => function ($query) {
                $query->where('is_available', true);
            }])
            ->orderBy('nama_kategori')
            ->get();

        return view('frontend.menu.index', compact('menus', 'kategoris', 'specials'));
    }

    public function create()
    {
        $kategoris = KategoriMenu::where('is_active', true)
            ->orderBy('nama_kategori')
            ->get();

        $stoks = Stok::orderBy('nama_bahan')->get();

        return view('admin.menu.create', compact('kategoris', 'stoks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'kategori_id' => 'nullable|exists:kategori_menu,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_available' => 'boolean',
            'stok' => 'nullable|integer|min:0',
            'ukuran' => 'nullable|string|max:100',
            'bahan' => 'nullable|string',
            'durasi_persiapan' => 'nullable|integer|min:1',

            'bahan_stok_id' => 'nullable|array',
            'bahan_stok_id.*' => 'nullable|exists:stok,id',
            'jumlah_dibutuhkan' => 'nullable|array',
            'jumlah_dibutuhkan.*' => 'nullable|numeric|min:0',
        ]);

        $data = $request->except([
            'gambar',
            'bahan_stok_id',
            'jumlah_dibutuhkan',
        ]);

        $data['is_available'] = $request->has('is_available');

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $filename = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('storage/menu'), $filename);
            $data['gambar'] = $filename;
        }

        $menu = Menu::create($data);

        if ($request->has('bahan_stok_id')) {
            foreach ($request->bahan_stok_id as $index => $stokId) {
                $jumlah = $request->jumlah_dibutuhkan[$index] ?? null;

                if ($stokId && $jumlah && $jumlah > 0) {
                    MenuBahan::create([
                        'menuable_id' => $menu->id,
                        'menuable_type' => Menu::class,
                        'stok_id' => $stokId,
                        'jumlah_dibutuhkan' => $jumlah,
                    ]);
                }
            }
        }

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    public function show(Menu $menu)
    {
        $menu->load('kategori');

        return view('admin.menu.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {$menu->komposisiBahan()->delete();
        $kategoris = KategoriMenu::where('is_active', true)
            ->orderBy('nama_kategori')
            ->get();

        $stoks = Stok::orderBy('nama_bahan')->get();

        $menu->load('komposisiBahan.stok');

        return view('admin.menu.edit', compact('menu', 'kategoris', 'stoks'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'kategori_id' => 'nullable|exists:kategori_menu,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_available' => 'boolean',
            'stok' => 'nullable|integer|min:0',
            'ukuran' => 'nullable|string|max:100',
            'bahan' => 'nullable|string',
            'durasi_persiapan' => 'nullable|integer|min:1',

            'bahan_stok_id' => 'nullable|array',
            'bahan_stok_id.*' => 'nullable|exists:stok,id',
            'jumlah_dibutuhkan' => 'nullable|array',
            'jumlah_dibutuhkan.*' => 'nullable|numeric|min:0',
        ]);

        $data = $request->except([
            'gambar',
            'bahan_stok_id',
            'jumlah_dibutuhkan',
        ]);

        $data['is_available'] = $request->has('is_available');

        if ($request->hasFile('gambar')) {
            if ($menu->gambar && file_exists(public_path('storage/menu/' . $menu->gambar))) {
                unlink(public_path('storage/menu/' . $menu->gambar));
            }

            $gambar = $request->file('gambar');
            $filename = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('storage/menu'), $filename);
            $data['gambar'] = $filename;
        }

        $menu->update($data);

        $menu->komposisiBahan()->delete();

        if ($request->has('bahan_stok_id')) {
            foreach ($request->bahan_stok_id as $index => $stokId) {
                $jumlah = $request->jumlah_dibutuhkan[$index] ?? null;

                if ($stokId && $jumlah && $jumlah > 0) {
                    MenuBahan::create([
                        'menuable_id' => $menu->id,
                        'menuable_type' => Menu::class,
                        'stok_id' => $stokId,
                        'jumlah_dibutuhkan' => $jumlah,
                    ]);
                }
            }
        }

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->gambar && file_exists(public_path('storage/menu/' . $menu->gambar))) {
            unlink(public_path('storage/menu/' . $menu->gambar));
        }

        $menu->komposisiBahan()->delete();

        $menu->delete();

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu berhasil dihapus!');
    }
}