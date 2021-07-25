<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Promo;
use App\Models\PromoProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Promo/Index', [
            'promo' => Promo::with('relatedProducts.relatedPhotos:product_id,image_url,image_alt_text')
                ->whereDate('promo_started_at', '>=', today())
                ->first()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Promo $promo
     * @return \Inertia\Response
     */
    public function show(Request $request, Promo $promo)
    {
        $promo_product = PromoProduct::findOrFail($request->promo_product_id);
        $product = $promo_product->loadMissing('relatedProduct')->relatedProduct;

        return Inertia::render('Promo/Show', [
            'promo_product' => $promo_product,
            'product' => $product->loadMissing('relatedCategory', 'relatedPhotos', 'relatedCart')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Promo $promo
     * @return Response
     */
    public function edit(Promo $promo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Promo $promo
     * @return Response
     */
    public function update(Request $request, Promo $promo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Promo $promo
     * @return Response
     */
    public function destroy(Promo $promo)
    {
        //
    }
}
