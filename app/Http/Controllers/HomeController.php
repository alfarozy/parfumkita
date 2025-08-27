<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\RentalOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function carts()
    {
        if (auth()->guest()) {
            return redirect()->route('login')->with('msg', 'Silahkan login terlebih dahulu');
        }
        $carts = Cart::where('user_id', auth()->user()->id)->latest()->get();

        return view('homepage.carts', compact('carts'));
    }

    public function removeCart($slug)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', Product::where('slug', $slug)->firstOrFail()->id)->firstOrFail();
        $cart->delete();

        return redirect()->route('homepage.carts')->with('success', 'Produk berhasil dihapus dari keranjang');
    }
    public function addToCart($slug)
    {
        if (auth()->guest()) {
            return redirect()->route('login')->with('success', 'Silahkan login terlebih dahulu');
        }

        $product = Product::where('slug', $slug)->firstOrFail();

        $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $product->id)->first();
        $quantity = request('quantity');
        if ($cart) {
            $cart->quantity += $quantity;
            $cart->save();
        } else {
            Cart::create([
                'user_id' => auth()->user()->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }
    public function index()
    {
        $products = Product::where('enabled', true)->latest()->take(8)->get();
        return view('homepage.index', compact('products'));
    }
    /*************  ✨ Windsurf Command 🌟  *************/
    public function products(Request $request)
    {
        // Ambil semua kategori aktif untuk ditampilkan di filter dropdown
        $categories = Category::where('enabled', true)->latest()->get();

        // Mulai query produk
        $query = Product::with('category')->where('enabled', true);

        // Jika ada filter kategori
        if ($request->has('category') && $request->category != 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        if ($request->has('type') && $request->type != 'all') {
            if ($request->type == 'male' || $request->type == 'female') {
                $query->whereIn('gender_target', ['unisex', $request->type]);
            }
        }

        if ($request->has('type') && $request->type == 'best') {
            $query->whereHas('category', function ($q) {
                $q->where('slug', 'best-seller');
            });
        }

        // Jika ada pencarian
        if ($request->has('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // Ambil produk terbaru
        $products = $query->latest()->paginate(12);

        return view('homepage.products', compact('categories', 'products'));
    }
    public function recomendationProducts(Request $request)
    {
        // Ambil semua kategori aktif untuk ditampilkan di filter dropdown
        $categories = Category::where('enabled', true)->latest()->get();

        // Mulai query produk
        $query = Product::with('category')->where('enabled', true);

        // Filter kategori (dropdown kategori biasa)
        if ($request->has('category') && $request->category != 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Filter berdasarkan gender_target dari kuisioner
        if ($request->has('gender_target') && in_array($request->gender_target, ['male', 'female', 'unisex'])) {
            if ($request->gender_target == 'male' || $request->gender_target == 'female') {
                $query->whereIn('gender_target', ['unisex', $request->gender_target]);
            } else {
                $query->where('gender_target', 'unisex');
            }
        }

        // Filter berdasarkan usage_time (morning, night, all_day)
        if ($request->has('usage_time') && in_array($request->usage_time, ['morning', 'night', 'all_day'])) {
            $query->where('usage_time', $request->usage_time);
        }

        // Filter berdasarkan situation (indoor, outdoor, mixed)
        if ($request->has('situation') && in_array($request->situation, ['indoor', 'outdoor', 'mixed'])) {
            $query->where('situation', $request->situation);
        }

        // Filter berdasarkan longevity (long_last, light_frequent)
        if ($request->has('longevity') && in_array($request->longevity, ['long_last', 'light_frequent'])) {
            $query->where('longevity', $request->longevity);
        }

        // Filter pencarian produk (opsional)
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // Ambil produk terbaru
        $products = $query->latest()->paginate(12);

        return view('homepage.recomendations', compact('categories', 'products'));
    }

    /*******  496c876c-f49c-46d6-bb9f-7692816e2c12  *******/

    public function productDetail($slug)
    {
        // Cari produk berdasarkan slug
        $product = Product::where('slug', $slug)
            ->with('category')
            ->firstOrFail();

        // Ambil produk lain selain yang sedang dibuka (max 4)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('homepage.products-detail', compact('product', 'relatedProducts'));
    }

    public function checkoutPage()
    {
        if (auth()->guest()) {
            return redirect()->route('login')->with('msg', 'Silahkan login terlebih dahulu');
        }
        $carts = Cart::where('user_id', auth()->user()->id)->latest()->get();

        return view('homepage.checkout', compact('carts'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'phone'            => 'required|string|max:20',
            'email'            => 'required|email',
            'shipping_address' => 'required|string',
            'notes'            => 'nullable|string',
        ]);

        // Ambil cart user
        $cart = Cart::where('user_id', auth()->id())->latest()->get();
        if ($cart->isEmpty()) {
            return redirect()->route('homepage.carts')
                ->with('error', 'Keranjang kosong, tidak bisa checkout.');
        }

        DB::beginTransaction();
        try {
            // Hitung total harga
            $totalPrice = $cart->sum(fn($item) => $item->quantity * $item->product->price);

            // Buat order utama
            $order = Order::create([
                'user_id'          => auth()->id(), // null kalau guest checkout
                'order_number'     => strtoupper(Str()->random(10)),
                'status'           => 'pending',
                'payment_status'   => 'unpaid',
                'payment_method'   => 'BANK BRI',
                'payment_proof'    => null,
                'total_price'      => $totalPrice,
                'phone_number'     => $request->phone,
                'shipping_address' => $request->shipping_address,
                'notes'            => $request->notes,
            ]);

            // Simpan detail pesanan
            foreach ($cart as $item) {
                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->quantity * $item->product->price,
                ]);
            }

            // Bersihkan cart setelah checkout
            Cart::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('user.orders.invoice', $order->order_number)
                ->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }
}
