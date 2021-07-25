<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\PromoProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Cart', [
            'carts' => Auth::user()->relatedCarts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $product = Product::findOrFail($request->product_id);
            $price_selling = $product->price_selling;

            $promo_product_id = null;
            if ($request->has('promo_product_id')) {
                $promo_product = PromoProduct::findOrFail($request->promo_product_id);
                $promo_product_id = $promo_product->promo_product_id;
                $price_selling = $promo_product->promo_price_selling;
            }
            Cart::with('relatedProduct')->updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'product_id' => $product->product_id,
                    'product_price' => $price_selling,
                ],
                [
                    'category_id' => $product->category_id,
                    'supplier_id' => $product->supplier_id,
                    'cart_qty' => $request->cart_qty,
                    'promo_id' => $request->has('promo_id') ? $request->promo_id : null,
                    'promo_product_id' => $promo_product_id,
                ]
            );

            return back()->with('message', 'Berhasil memasukkan produk ke dalam Keranjang Belanja Anda.');
        } catch (Throwable $e) {
            return back()->withErrors($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
