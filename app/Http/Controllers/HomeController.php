<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Homepage', [
            'appName' => config('app.name'),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'categories' => Category::query()->withCount('relatedProducts')->limit(2)->get(),
            'products' => Product::with('relatedPhotos:product_id,image_url,image_alt_text')->latest()->get()
        ]);
    }
}
