<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\RentalOrder;
use Illuminate\Http\Request;

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

    public function checkout()
    {
        if (auth()->guest()) {
            return redirect()->route('login')->with('msg', 'Silahkan login terlebih dahulu');
        }
        $carts = Cart::where('user_id', auth()->user()->id)->latest()->get();

        return view('homepage.checkout', compact('carts'));
    }

    public function rentalStore(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)
            ->with('category')
            ->firstOrFail();

        // Validasi input
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'delivery_option' => 'required|in:pickup,delivery',
            'delivery_address' => 'nullable|string|max:255',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string|max:255',
            'rental_phone' => 'required|string|max:255',
        ]);

        // Hitung total hari
        $start = new \DateTime($request->start_date);
        $end   = new \DateTime($request->end_date);
        $days  = $start->diff($end)->days + 1;

        // Hitung total biaya
        $deliveryCost = $request->delivery_option === 'delivery' ? 20000 : 0;
        $totalCost    = ($product->price * $request->quantity * $days) + $deliveryCost;

        // Simpan data rental
        $rental = RentalOrder::create([
            'user_id'          => auth()->id(),
            'order_number'    => 'AZM-' . date('Ymd') . '-' . str_pad(RentalOrder::count() + 1, 3, '0', STR_PAD_LEFT),
            'product_id'       => $product->id,
            'quantity'         => $request->quantity,
            'rental_phone'     => $request->rental_phone,
            'start_date'       => $request->start_date,
            'end_date'         => $request->end_date,
            'delivery_option'  => $request->delivery_option,
            'delivery_address' => $request->delivery_option === 'delivery' ? $request->delivery_address : null,
            'payment_method'   => $request->payment_method,
            'notes'            => $request->notes,
            'total_price'       => $totalCost,
            'status'           => 'pending', // default status
        ]);
        //> return ke detail invoice
        return redirect()->route('user.orders.invoice', $rental->order_number);
    }
}
