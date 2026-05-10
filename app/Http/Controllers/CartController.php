<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuSpecialItem;
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
     * Add normal menu item to cart
     */
    public function add(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        if (!$menu->is_available) {
            return redirect()->back()
                ->with('error', 'Menu tidak tersedia!');
        }

        $cart = session()->get('cart', []);
        $qty = (int) $request->input('qty', 1);

        if ($qty < 1) {
            $qty = 1;
        }

        $cartKey = 'menu_' . $menu->id;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['qty'] += $qty;
        } else {
            $cart[$cartKey] = [
                'id' => $menu->id,
                'type' => 'menu',
                'nama' => $menu->nama_menu,
                'harga' => $menu->harga,
                'gambar' => $menu->gambar,
                'qty' => $qty,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()
            ->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    /**
     * Add special menu item to cart
     */
    public function addSpecialItem(Request $request, $id)
    {
        $specialItem = MenuSpecialItem::findOrFail($id);

        if (!$specialItem->is_available) {
            return redirect()->back()
                ->with('error', 'Menu spesial tidak tersedia!');
        }

        $cart = session()->get('cart', []);
        $qty = (int) $request->input('qty', 1);

        if ($qty < 1) {
            $qty = 1;
        }

        $cartKey = 'special_' . $specialItem->id;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['qty'] += $qty;
        } else {
            $cart[$cartKey] = [
                'id' => $specialItem->id,
                'type' => 'special',
                'nama' => $specialItem->name,
                'harga' => $specialItem->price,
                'gambar' => $specialItem->image,
                'qty' => $qty,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')
            ->with('success', 'Menu spesial berhasil ditambahkan ke keranjang!');
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        $cartKey = $this->findCartKey($cart, $id);

        if ($cartKey !== null) {
            unset($cart[$cartKey]);
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
        $qty = (int) $request->input('qty', 1);

        $cartKey = $this->findCartKey($cart, $id);

        if ($cartKey !== null) {
            if ($qty <= 0) {
                unset($cart[$cartKey]);
            } else {
                $cart[$cartKey]['qty'] = $qty;
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

        $cartKey = $this->findCartKey($cart, $id);

        if ($cartKey !== null) {
            $cart[$cartKey]['qty']++;
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

        $cartKey = $this->findCartKey($cart, $id);

        if ($cartKey !== null) {
            $cart[$cartKey]['qty']--;

            if ($cart[$cartKey]['qty'] <= 0) {
                unset($cart[$cartKey]);
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
            'total_formatted' => 'Rp ' . number_format($total, 0, ',', '.'),
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
            'count' => array_sum(array_column($cart, 'qty')),
        ];
    }

    /**
     * Find cart key from old numeric id or new cart key format.
     */
    private function findCartKey(array $cart, $id): ?string
    {
        if (isset($cart[$id])) {
            return (string) $id;
        }

        foreach ($cart as $key => $item) {
            if ((string) ($item['id'] ?? '') === (string) $id) {
                return (string) $key;
            }
        }

        return null;
    }
}