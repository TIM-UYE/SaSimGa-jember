<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = $this->calculateTotal($cart);

        return view('frontend.cart.index', compact('cart', 'total'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        // Check if menu is available
        if (!$menu->is_available) {
            return redirect()->back()
                ->with('error', 'Menu tidak tersedia!');
        }

        $cart = session()->get('cart', []);
        $qty = $request->input('qty', 1);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty;
        } else {
            $cart[$id] = [
                'id' => $menu->id,
                'nama' => $menu->nama_menu,
                'harga' => $menu->harga,
                'gambar' => $menu->gambar,
                'qty' => $qty
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()
            ->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()
            ->with('success', 'Menu dihapus dari keranjang!');
    }

    /**
     * Update item quantity in cart
     */
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $qty = $request->input('qty', 1);

        if (isset($cart[$id])) {
            if ($qty <= 0) {
                // Remove item if qty is 0 or negative
                unset($cart[$id]);
            } else {
                $cart[$id]['qty'] = $qty;
            }
            session()->put('cart', $cart);
        }

        return redirect()->back()
            ->with('success', 'Quantity berhasil diupdate!');
    }

    /**
     * Increase item quantity
     */
    public function increment($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
            session()->put('cart', $cart);
        }

        return redirect()->back()
            ->with('success', 'Quantity berhasil ditambah!');
    }

    /**
     * Decrease item quantity
     */
    public function decrement($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty']--;

            if ($cart[$id]['qty'] <= 0) {
                unset($cart[$id]);
            }

            session()->put('cart', $cart);
        }

        return redirect()->back()
            ->with('success', 'Quantity berhasil dikurangi!');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        session()->forget('cart');

        return redirect()->back()
            ->with('success', 'Keranjang berhasil dikosongkan!');
    }

    /**
     * Get cart count and total for display
     */
    public function count()
    {
        $cart = session()->get('cart', []);
        $count = 0;
        $total = 0;

        foreach ($cart as $item) {
            $count += $item['qty'];
            $total += $item['harga'] * $item['qty'];
        }

        return response()->json([
            'count' => $count,
            'total' => $total,
            'total_formatted' => 'Rp ' . number_format($total, 0, ',', '.')
        ]);
    }

    /**
     * Calculate total price from cart
     */
    protected function calculateTotal(array $cart): float
    {
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['harga'] * $item['qty'];
        }

        return $total;
    }

    /**
     * Get cart data for checkout
     */
    public function getCartForCheckout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return null;
        }

        $total = $this->calculateTotal($cart);

        return [
            'items' => $cart,
            'total' => $total,
            'count' => array_sum(array_column($cart, 'qty'))
        ];
    }
}
