<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        return view('frontend.cart.index', compact('cart'));
    }

    public function add($id)
    {
        $menu = Menu::findOrFail($id);

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {

            $cart[$id]['qty']++;

        } else {

            $cart[$id] = [
                'id' => $menu->id,
                'nama' => $menu->nama_menu,
                'harga' => $menu->harga,
                'gambar' => $menu->gambar,
                'qty' => 1
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()
            ->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {

            unset($cart[$id]);

            session()->put('cart', $cart);
        }

        return redirect()->back()
            ->with('success', 'Menu dihapus dari keranjang!');
    }
}
